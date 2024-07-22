<?php

namespace App\Controllers;

use App\Models\PelangganModel;

class Pelanggan extends BaseController
{
    private $PelangganModel;
    public function __construct()
    {
        $this->PelangganModel = new PelangganModel();
    }
    public function index()
    {
        $dataPelanggan = $this->PelangganModel->getPelanggan();
        $data = [
            'title' => 'Data Pelanggan',
            'result' => $dataPelanggan
        ];
        return view('Pelanggan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pelanggan'
        ];
        return view('Pelanggan/create', $data);
    }

    public function save()
    {
        $Pelanggan_myth = new Pelangganmodel();
        $Pelanggan_myth->save(
            [
                'Nama_Pelanggan' => $this->request->getVar('Nama_Pelanggan'),
                'No_HP' => $this->request->getVar('No_HP'),
            ]
        );
        return redirect()->to('/Pelanggan');
    }

    public function edit($id)
    {
        $dataPelanggan = $this->PelangganModel->getPelanggan($id);
        $data = [
            'title' => 'Data Pelanggan',
            'result' => $dataPelanggan
        ];
        return view('Pelanggan/edit', $data);
    }

    public function update($id)
    {
        $Pelanggan_myth = new PelangganModel();
        $this->PelangganModel->save([
            'ID_Pelanggan' => $id,
            'Nama_Pelanggan' => $this->request->getVar('Nama_Pelanggan'),
            'No_HP' => $this->request->getVar('No_HP'),
        ]);

        session()->setFlashdata('msg', 'Berhasil memperbarui pelanggan');
        return redirect()->to('/Pelanggan');
    }

    public function delete($id)
    {
        $this->PelangganModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/Pelanggan');
    }
}
