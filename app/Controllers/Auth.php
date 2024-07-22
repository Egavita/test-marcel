<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\PenggunaModel;

use CodeIgniter\I18n\Time;

class Auth extends Controller
{
    public function indexregister()
        {
            helper(['form']);
            $data = [];

            return view('auth/register', $data);
        }

    public function saveRegister()
    {
        helper(['form']);
        //set rules validation form
        $rules  = [
            'Username'      => 'required|min_length[3]|max_length[20]',
            'Nama_Pengguna' => 'required|min_length[6]|max_length[30]',
            'Password'      => 'required|min_length[6]|max_length[200]',
            'pass_confirm'  => 'matches[Password]'
        ];
        // dd($rules);
        // $validation = \config\Services::validation();
        if ($this->validate($rules)) {
            $model = new PenggunaModel();
            $data = [
                'Username'         => $this->request->getVar('Username'),
                'Nama_Pengguna'    => $this->request->getVar('Nama_Pengguna'),
                'Password'         => password_hash($this->request->getVar('Password'),PASSWORD_DEFAULT),
            ];
            $model->save($data);
            return redirect()->to('/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('auth/register', $data);
        }
    }

    public function indexlogin()
    {
        helper(['form']);
        echo view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model   = new PenggunaModel();
        $email   = $this->request->getVar('Username');
        // $username = $this->request->getVar('email');
        // dd($email);
        $password = $this->request->getVar('Password');
        $data     = $model->where('Username', $email)->orwhere('Username', $email)->first();
        // dd($data);
        if ($data) {
            $pass = $data['Password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'ID_Pengguna'   => $data['ID_Pengguna'],
                    'Username'      => $data['Username'],
                    'role'          => $data['role'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login')->withInput();
            }
        } else {
            $session->setFlashdata('msg', 'Username Tidak ada');
            return redirect()->to('/login')->withInput();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}