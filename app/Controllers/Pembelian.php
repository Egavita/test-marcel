<?php

namespace App\Controllers;

use \App\Models\ProdukModel;
use \App\Models\PenggunaModel;
use \App\Models\supplierModel;
use \App\Models\BuyModel;
use \App\Models\BuyDetailModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pembelian extends BaseController
{
    private $produk, $cart, $pengguna, $supplier, $buy, $buyDetail;
    public function __construct()
    {
        $this->produk = new ProdukModel();
        $this->pengguna = new PenggunaModel();
        $this->buy = new BuyModel();
        $this->buyDetail = new BuyDetailModel();
        $this->supplier = new supplierModel();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $this->cart->destroy();
        $produk = $this->produk->getProduk();
        $supplier = $this->supplier->findAll();
        $data = [
            'title' => 'Pembelian',
            'produk' => $produk,
            'supplier' => $supplier,
        ];
        return view('pembelian/list', $data);
    }

    public function addCart()
    {
        $this->cart->insert(
            array(
                'id' => $this->request->getVar('id'),
                'qty' => $this->request->getVar('qty'),
                'price' => $this->request->getVar('price'),
                'name' => $this->request->getVar('name')
            )
        );
        echo $this->showCart();
    }

    public function showCart()
    {
        $output = '';
        $no = 1;
        foreach ($this->cart->contents() as $items) {
            $output .= '
            <tr>
            <td>' . $no++ . '</td>
            <td>' . $items['name'] . '</td>
            <td>' . $items['qty'] . '</td>
            <td>' . number_to_currency($items['price'], 'IDR', 'id_ID', 2) . '</td>
            <td>' . number_to_currency($items['subtotal'], 'IDR', 'id_ID', 2) . '</td>
            <td>
            <button id="' . $items['rowid'] . '" qty="' . $items['qty'] . '" 
            class="ubah_cart btn btn-warning btn-xs" title="Ubah Jumlah"><i class="fa 
            fa-edit"></i></button>
            <button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn 
            btn-danger btn-xs"><i class="fa fa-trash" title="Hapus"></i></button>
            </td>
            </tr>
            ';
        }

        if (!$this->cart->contents()) {
            $output = '<tr><td colspan ="7" align="center">Tidak ada transaksi!</td></tr>';
        }
        return $output;
    }

    public function loadCart()
    {
        //load data cart
        echo $this->showCart();
    }

    public function getTotal()
    {
        $totalBayar = 0;
        foreach ($this->cart->contents() as $items) {
            $totalBayar += $items['subtotal'];
        }
        echo number_to_currency($totalBayar, 'IDR', 'id_ID', 2);
    }

    public function updateCart()
    {
        $this->cart->update(
            array(
                'rowid' => $this->request->getVar('rowid'),
                'qty' => $this->request->getVar('qty')
            )
        );
        echo $this->showCart();
    }

    public function deleteCart($rowid)
    {
        $this->cart->remove($rowid);
        echo $this->loadCart();
    }

    public function pembayaran()
    {
        //Mengecek Apakah Ada transaksi Yang Dilakukan
        if (!$this->cart->contents()) {
            //Transaksi Kosong
            $response = [
                'status' => false,
                'msg' => "Tidak Ada Transaksi!",
            ];
            echo json_encode($response);
            return;
        } else {
            //Ada Transaksi
            $totalBayar = 0;
            foreach ($this->cart->contents() as $items) {
                $totalBayar += $items['subtotal'];
            }

            $nominal = $this->request->getVar('nominal');
            $id = time();

            if ($nominal < $totalBayar) {
                $response = [
                    'status' => false,
                    'msg' => "Nominal Pembayaran Kurang!",
                ];
                echo json_encode($response);
            }
        }
        $this->buy->save([
            'ID_Beli' => $id,
            'ID_Pengguna' => session()->ID_Pengguna
        ]);

        foreach ($this->cart->contents() as $items) {
            $this->buyDetail->save([
                'ID_Beli' => $id,
                'ID_Produk' => $items['id'],
                'Jumlah' => $items['qty'],
                'Harga' => $items['price'],
                'Total_Harga' => $items['subtotal']
            ]);
            $produk = $this->produk->where(['ID_Produk' => $items['id']])->first();
            $this->produk->save([
                'ID_Produk' => $items['id'],
                'Qty' => $produk['Qty'] + $items['qty'],
            ]);
        }
        $this->cart->destroy();
        $kembalian = $nominal - $totalBayar;

        $response = [
            'status' => true,
            'msg' => "Pembayaran Berhasil!",
            'data' => [
                'kembalian' => number_to_currency(
                    $kembalian,
                    'IDR',
                    'id_ID',
                    2
                )
            ]
        ];
        echo json_encode($response);
    }
    public function report($tgl_awal = null, $tgl_akhir = null)
    {
        $_SESSION['tgl_awal'] = $tgl_awal == null ? date('Y-m-01') : $tgl_awal;
        $_SESSION['tgl_akhir'] = $tgl_akhir == null ? date('Y-m-t') : $tgl_akhir;

        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->buy->getReport($tgl1, $tgl2);
        $data = [
            'title' => 'Laporan Pembelian',
            'result' => $report,
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' => $tgl2,
            ],
        ];
        return view('pembelian/report', $data);
    }

    public function exportPDF()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->buy->getReport($tgl1, $tgl2);
        foreach($report as $value){
            $total += $value->total;
        }
        $data = [
            'title' => 'Laporan Pembelian',
            'result' => $report,
            'total' => $total
        ];

        $html = view('pembelian/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('aplication/pdf');
        $pdf->Output('laporan-pembelian.pdf', 'I');
    }

    public function notaPDF($ID_Beli)
    {
        $report = $this->buyDetail->getInvoice($ID_Beli);
        $data = [
            'title' => 'Laporan Pembelian',
            'result' => $report,
        ];

        $html = view('pembelian/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('aplication/pdf');
        $pdf->Output('laporan-pembelian.pdf', 'I');
    }

    public function exportExcel()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->buy->getReport($tgl1, $tgl2);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Produk')
            ->setCellValue('C1', 'Pengguna')
            ->setCellValue('D1', 'Tanggal Transaksi')
            ->setCellValue('E1', 'Total');

        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['ID_Beli'])
                ->setCellValue('C' . $rows, $value['Nama_Pengguna'])
                ->setCellValue('D' . $rows, $value['tgl_transaksi'])
                ->setCellValue('E' . $rows, $value['total']);
            $rows++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Pembelian';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function notaExcel($ID_Beli)
    {
        $report = $this->buyDetail->getInvoice($ID_Beli);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Produk')
            ->setCellValue('C1', 'Pengguna')
            ->setCellValue('D1', 'Tanggal Transaksi')
            ->setCellValue('E1', 'Produk')
            ->setCellValue('F1', 'Total');

        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['ID_Beli'])
                ->setCellValue('C' . $rows, $value['Nama_Pengguna'])
                ->setCellValue('D' . $rows, $value['tgl_transaksi'])
                ->setCellValue('E' . $rows, $value['Nama_Produk'])
                ->setCellValue('F' . $rows, $value['total']);
            $rows++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Pembelian';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function filter()
    {
        $_SESSION['tgl_awal'] = $this->request->getVar('tgl_awal');
        $_SESSION['tgl_akhir'] = $this->request->getVar('tgl_akhir');
        return $this->report($_SESSION['tgl_awal'], $_SESSION['tgl_akhir']);
    }
}
