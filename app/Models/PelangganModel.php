<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'ID_Pelanggan';
    protected $useTimestamps = true;
    protected $allowedFields = ['Nama_Pelanggan', 'No_HP'];

    protected $useSoftDeletes = true;

    public function getPelanggan($slug = false)
    {
        $query = $this->table('pelanggan')
            ->where('deleted_at is null');

        if ($slug === false) {
            return $query->findAll();
        } else {
            return $query->where(['ID_Pelanggan' => $slug])->first();
        }
    }
}
