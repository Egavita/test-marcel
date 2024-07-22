<?php
namespace App\Controllers;

use App\Models\PenggunaModel;

class Pengguna extends BaseController
{
    private $PenggunaModel;
    public function __construct()
    {
        $this->PenggunaModel = new PenggunaModel ();
    }
    public function index()
    {
        $dataPengguna = $this->PenggunaModel->getPengguna();
        $data = [
            'title' => 'Data Pengguna',
            'result' => $dataPengguna
        ];
        return view('Pengguna/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna'
        ];
        return view('Pengguna/create', $data);
    }

    public function save()
    {
        $Pengguna_myth = new Penggunamodel();
        $role= $this->request->getVar('role');
        // dd($role);
        $Pengguna_myth->save([
            'Nama_Pengguna' => $this->request->getVar('Nama_Pengguna'),
            'Username' => $this->request->getVar('Username'),
            'role'      => $role,
            'Password' => password_hash($this->request->getVar('Password'), PASSWORD_DEFAULT),
        ]);
        return redirect()->to('/Pengguna');
    }

    public function edit($id)
    {
        $dataPengguna = $this->PenggunaModel->getPengguna($id);
        $data = [
            'title' => 'Data Pengguna',
            'result' => $dataPengguna
        ];
        return view('Pengguna/edit', $data);
    }

    public function update($id)
    {
        $Pengguna_myth = new PenggunaModel();
        $role= $this->request->getVar('role');
        // dd($role);
        $Pengguna_myth->update($id, [
            'Nama_Pengguna' => $this->request->getVar('Nama_Pengguna'),
            'Username' => $this->request->getVar('Username'),
            'role'      => $role,
        ]);

        session()->setFlashdata('msg', 'Berhasil memperbarui Pengguna');
        return redirect()->to('/Pengguna');
    }

    public function delete($id)
    {
        $this->PenggunaModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/Pengguna');
    }
}