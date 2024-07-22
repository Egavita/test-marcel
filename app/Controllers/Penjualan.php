<?php

namespace App\Controllers;

use \App\Models\LayananModel;
use \App\Models\ProdukModel;
use \App\Models\PelangganModel;
use \App\Models\SaleModel;
use \App\Models\SaleDetailModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;

class Penjualan extends BaseController
{
    private $Layanan, $produk, $cart, $cust, $sale, $saleDetail;
    public function __construct()
    {
        $this->Layanan = new LayananModel();
        $this->produk = new ProdukModel();
        $this->cust = new PelangganModel();
        $this->sale = new SaleModel();
        $this->saleDetail = new SaleDetailModel();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $this->cart->destroy();
        $dataLayanan = $this->Layanan->getLayanan();
        $produk = $this->produk->getProduk();
        $cust = $this->cust->findAll();
        $data = [
            'title' => 'Penjualan',
            'dataLayanan' => $dataLayanan,
            'produk' => $produk,
            'cust' => $cust,
        ];
        // dd($data);
        return view('penjualan/list', $data);
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
            $output = '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        }
        return $output;
    }

    public function loadCart()
    {
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
            $produk = session()->ID_Pengguna;
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
        $this->sale->save([
            'No_Transaksi' => $id,
            'ID_Pengguna' => session()->ID_Pengguna,
            'ID_Pelanggan' => $this->request->getVar('ID_Pelanggan'),
            'Tanggal_Transaksi' => Time::now('Asia/Bangkok', 'en_US'),
        ]);

        foreach ($this->cart->contents() as $items) {
            $this->saleDetail->save([
                'No_Transaksi' => $id,
                'ID_Layanan' => $items['id'],
                'ID_Produk' => $this->request->getVar('ID_Produk'),
                'Jumlah' => $items['qty'],
                'Harga' => $items['price'],
                'Total_Harga' => $items['subtotal']
            ]);
            $produk = $this->produk->where(['ID_Produk' => $this->request->getVar('ID_Produk')])->first();
            $this->produk->save([
                'ID_Produk' => $this->request->getVar('ID_Produk'),
                'Qty' => $produk['Qty'] - $items['qty'],
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

        $report = $this->sale->getReport($tgl1, $tgl2);
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' => $tgl2,
            ],
        ];
        return view('penjualan/report', $data);
    }

    public function exportPDF()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->sale->getReport($tgl1, $tgl2);
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
        ];
        // dd($data);

        $html = view('penjualan/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('aplication/pdf');
        $pdf->Output('laporan-penjualan.pdf', 'I');
    }

    public function notaPDF($No_Transaksi)
    {
        // dd($No_Transaksi);
        $report = $this->saleDetail->getInvoice($No_Transaksi);
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
        ];
        $html = view('penjualan/notaPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('aplication/pdf');
        $pdf->Output('laporan-penjualan.pdf', 'I');
    }

    public function exportExcel()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->sale->getReport($tgl1, $tgl2);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'No Transaksi')
            ->setCellValue('C1', 'Pengguna')
            ->setCellValue('D1', 'Tanggal Transaksi')
            ->setCellValue('E1', 'Pelanggan')
            ->setCellValue('F1', 'Layanan')
            ->setCellValue('G1', 'Total');

        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['No_Transaksi'])
                ->setCellValue('C' . $rows, $value['Nama_Pengguna'])
                ->setCellValue('D' . $rows, $value['tgl_transaksi'])
                ->setCellValue('E' . $rows, $value['Nama_Pelanggan'])
                ->setCellValue('F' . $rows, $value['Nama_Layanan'])
                ->setCellValue('G' . $rows, $value['total']);
            $rows++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Penjualan';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function notaExcel($No_Transaksi)
    {
        // dd($No_Transaksi);
        $report = $this->saleDetail->getInvoice($No_Transaksi);
        // dd($report);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'No Transaksi')
            ->setCellValue('C1', 'Pengguna')
            ->setCellValue('D1', 'Tanggal Transaksi')
            ->setCellValue('E1', 'Pelanggan')
            ->setCellValue('F1', 'Layanan')
            ->setCellValue('G1', 'Total');

        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['No_Transaksi'])
                ->setCellValue('C' . $rows, $value['Nama_Pengguna'])
                ->setCellValue('D' . $rows, $value['tgl_transaksi'])
                ->setCellValue('E' . $rows, $value['Nama_Pelanggan'])
                ->setCellValue('F' . $rows, $value['Nama_Layanan'])
                ->setCellValue('G' . $rows, $value['total']);
            $rows++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Penjualan';

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
