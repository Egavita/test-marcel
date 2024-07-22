<?php

namespace App\Controllers;

use \App\Models\LayananModel;
use App\Models\KategoriModel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Layanan extends BaseController
{
    protected $helpers = ['form'];
    private $LayananModel, $KatModel;
    public function __construct()
    {
        $this->LayananModel = new LayananModel();
        $this->KatModel = new KategoriModel();
    }

    public function index()
    {
        $dataLayanan = $this->LayananModel->getLayanan();
        $data = [
            'title' => 'Data Layanan',
            'result' => $dataLayanan
        ];
        // dd($data);
        return view('Layanan/index', $data);
    }

    public function detail($slug)
    {
        $dataLayanan = $this->LayananModel->getLayanan($slug);
        $data = [
            'title' => 'Detail Layanan',
            'result' => $dataLayanan
        ];
        return view('Layanan/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Layanan',
            'category' => $this->KatModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('Layanan/create', $data);
    }

    public function save()
    {
        $validation = \config\Services::validation();
        if (!$this->validate([
            'Nama_Layanan' => [
                'rules' => 'required|is_unique[Layanan.Nama_Layanan]',
                'label' => 'Nama_Layanan',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{filed} hanya sudah ada'
                ]
            ],
            'Harga_Layanan' => 'required|decimal',
        ])) {
            $data = [
                'title' => 'Tambah Layanan',
                'category' => $this->KatModel->findAll(),
                'validation' => \config\Services::validation()
            ];
            $data['validation'] = $this->validator;
            return view('Layanan/create', $data);
        }

        $this->LayananModel->save([
            'Nama_Layanan' => $this->request->getVar('Nama_Layanan'),
            'Harga_Layanan' => $this->request->getVar('Harga_Layanan'),
            'ID_Kategori_Layanan' => $this->request->getVar('ID_Kategori_Layanan'),
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan!");
        return redirect()->to('/Layanan');
    }

    public function edit($slug)
    {
        $dataLayanan = $this->LayananModel->getLayanan($slug);
        if (empty($dataLayanan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Nama Layanan $slug tidak ditemukan!");
        }
        $data = [
            'title' => 'Ubah Layanan',
            'category' => $this->KatModel->FindAll(),
            'validation' => \Config\Services::validation(),
            'result' => $dataLayanan
        ];
        //dd($dataLayanan);
        return view('Layanan/edit', $data);
    }

    public function update($id)
    {
        $dataOld = $this->LayananModel->getLayanan($this->request->getVar('ID_Layanan'));
        if ($dataOld['Nama_Layanan'] == $this->request->getVar('Nama_Layanan')) {
            $rule_Nama_Layanan = 'required';
        } else {
            $rule_Nama_Layanan = 'required|is_unique[Layanan.Nama_Layanan]';
        }
        if (!$this->validate([
            'Nama_Layanan' => [
                'rules' => $rule_Nama_Layanan,
                'label' => 'Nama Layanan',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{filed} hanya sudah ada'
                ]
            ],
            'Harga_Layanan' => 'required|decimal',
        ])) {
            return redirect()->back()->withInput();
        }

        $slug = url_title($this->request->getVar('Nama_Layanan'), '-', true);
        $this->LayananModel->save([
            'ID_Layanan' => $id,
            'Nama_Layanan' => $this->request->getVar('Nama_Layanan'),
            'Harga_Layanan' => $this->request->getVar('Harga_Layanan'),
            'ID_Kategori_Layanan' => $this->request->getVar('ID_Kategori_Layanan'),
            'slug' => $slug,
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");
        return redirect()->to('/Layanan');
    }

    public function delete($id)
    {
        $dataLayanan = $this->LayananModel->find($id);
        $this->LayananModel->delete($id);

        session()->setFlashdata("msg", "Data berhasil dihapus");
        return redirect()->to('/Layanan');
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
            $dataOld = $this->LayananModel->getLayanan($slug);
            if (!$dataOld) {
                $this->LayananModel->save([
                    'Nama_Layanan' => $value[1],
                    'Harga_Layanan' => $value[2] ?? 0,
                    'ID_Kategori_Layanan' => $value[3],
                    'slug' => $slug,
                ]);
            } else if ($dataOld['Nama_Layanan'] != $value[1]) {
                $this->LayananModel->save([
                    'Nama_Layanan' => $value[1],
                    'Harga_Layanan' => $value[2] ?? 0,
                    'ID_Kategori_Layanan' => $value[3],
                    'slug' => $slug,
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/Layanan');
    }
}
