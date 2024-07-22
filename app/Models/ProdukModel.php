<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table        = 'Produk';
    protected $primaryKey   = 'ID_Produk';
    // protected $useTimestamps    = true;
    protected $allowedFields = [
        'Nama_Produk', 'Brand_Produk', 'Harga_Produk',
        'Qty', 'Tanggalexp'
    ];

    protected $useSoftDeletes = true;

    public function getProduk($ID_Produk = false)
    {
        $query = $this->table('produk')
        ->where('deleted_at is null');

        if ($ID_Produk == false)
            return $query->get()->getResultArray();
        return $query->where(['ID_Produk' => $ID_Produk])->first();
    }

    // public function getProduk($ID_Produk = false)
    // {
    //     if ($ID_Produk == false) {
    //         return $this->get()->getResultArray();
    //     } else {
    //         $this->where(['ID_Produk' => $ID_Produk]);
    //         return $this->first();
    //     }
    // }
}
