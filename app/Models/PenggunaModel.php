<?php

namespace App\Models;

class PenggunaModel extends LayananModel
{
    //nama tabel
    protected $table = 'pengguna';
    protected $primaryKey = 'ID_Pengguna';
    protected $useTimestamps = true;
    protected $allowedFields = ['Nama_Pengguna', 'Username', 'Password', 'role'];

    protected $useSoftDeletes = true;
    
    public function getPengguna($slug = false)
    {
        $query = $this->table('pengguna')
        ->where('deleted_at is null');

        if ($slug === false){
            return $query->findAll();
        } else {
            return $query->where(['ID_Pengguna' => $slug])->first();
        }
    }
}