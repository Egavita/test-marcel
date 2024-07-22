<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\ProdukKategoriModel;
use CodeIgniter\Database\SQLite3\Result;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use CodeIgniter\I18n\Time;

class Produk extends BaseController
{

    // private $bookModel;
    // public function __construct()
    // {
    //     $this->bookModel = new BookModel();
    // }
    protected $helpers = ['form'];
    private $ProdukModel, $ProdukKategoriModel;
    public function __construct()
    {
        $this->ProdukModel = new ProdukModel();
        $this->ProdukKategoriModel = new ProdukKategoriModel();
    }

    public function index()
    {
        // $komikModel = new KomikModel();
        $dataproduk = $this->ProdukModel->getProduk();
        $data = [
            'title' => 'Data Produk',
            'result' => $dataproduk
        ];
        // dd($data);
        return view('Produk/index', $data);
        // dd($dataBook);
    }
    public function detail($ID_Produk)
    {
        $dataproduk = $this->ProdukModel->getProduk($ID_Produk);
        $data = [
            'title' => 'Data Produk',
            'result' => $dataproduk
        ];
        // dd($data);
        return view('Produk/detail', $data);
        // dd($dataBook);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'validation' => \Config\Services::validation()
        ];
        // dd($data);
        return view('Produk/create', $data);
    }

    public function save()
    {
        $validation = \config\Services::validation();
        if (!$this->validate([
            'Nama_Produk' => [
                'rules' => 'required|is_unique[Produk.Nama_Produk]',
                'label' => 'Nama Produk',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'Brand_Produk' => [
                'rules' => 'required',
                'label' => 'Brand Produk',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'Qty' => [
                'rules' => 'required|integer',
                'label' => 'Stok',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'Harga_Produk' => [
                'rules' => 'required|decimal',
                'label' => 'Harga Produk',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'decimal' => '{field} hanya boleh angka atau decimal!'
                ]
            ],

        ])) {
            return redirect()->to('Produk/create/' . $this->request->getVar('Nama_Produk'))->withInput();
        }
        $this->ProdukModel->save([
            'Nama_Produk' => $this->request->getVar('Nama_Produk'),
            'Brand_Produk' => $this->request->getVar('Brand_Produk'),
            'Harga_Produk' => $this->request->getVar('Harga_Produk'),
            'Qty' => $this->request->getVar('Qty'),
            'Tanggalexp' => Time::now('Asia/Bangkok', 'en_US'),
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan!");
        return redirect()->to('/Produk');
    }

    public function edit($ID_Produk)
    {
        $dataProduk = $this->ProdukModel->getProduk($ID_Produk);
        if (empty($dataProduk)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk $ID_Produk tidak ditemukan!");
        }
        $data = [
            'title' => 'Ubah Produk',
            'validation' => \Config\Services::validation(),
            'result' => $dataProduk
        ];
        //dd($dataKomik);
        return view('Produk/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'Nama_Produk' => [
                'rules' => 'required',
                'label' => 'Nama Produk',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'Brand_Produk' => 'required',
            'Harga_Produk' => 'required|decimal',
            'Qty' => 'required|integer',
        ])) {
            return redirect()->back()->withInput();
        }

        $slug = url_title($this->request->getVar('Nama_Produk'), '-', true);
        $this->ProdukModel->update($id, [
            'ID_Produk' => $id,
            'Nama_Produk' => $this->request->getVar('Nama_Produk'),
            'Brand_Produk' => $this->request->getVar('Brand_Produk'),
            'Harga_Produk' => $this->request->getVar('Harga_Produk'),
            'Qty' => $this->request->getVar('Qty'),
            'slug' => $slug,
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");
        return redirect()->to('/Produk');
    }

    public function delete($id)
    {
        $dataProduk = $this->ProdukModel->find($id);
        $this->ProdukModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus");
        return redirect()->to('/Produk');
    }

    public function importData()
    {
        $file = $this->request->getFile("file");
        $ext = $file->getExtension();
        if ($ext == "xls")
            $reader = new Xls();
        else
            $reader = new Xlsx();

        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value) {
            if ($key == 0) continue;

            $slug = url_title($value[1], '-', true);

            // Cek judul
            $dataOld = $this->ProdukModel->getProduk($slug);
            if (!$dataOld) {
                $this->ProdukModel->save([
                    'Nama_Produk' => $value[1],
                    'Brand' => $value[2],
                    'Harga_Produk' => $value[3] ?? 0,
                    'Stok' => $value[4],
                    'ID_Kategori_Komik' => $value[5],
                    'slug' => $slug,
                ]);
            } else if ($dataOld['title'] != $value[1]) {
                $this->ProdukModel->save([
                    'Nama_Produk' => $value[1],
                    'Brand' => $value[2],
                    'Harga_Produk' => $value[3] ?? 0,
                    'Stok' => $value[4],
                    'ID_Kategori_Komik' => $value[5],
                    'slug' => $slug,
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/Produk');
    }
}
