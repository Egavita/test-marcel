<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyDetailModel extends Model
{
    protected $table = 'beli_detail';
    protected $allowedFields = ['ID_Beli', 'ID_Produk', 'Jumlah', 'Harga', 'Total_Harga'];

    public function getInvoice($ID_Beli)
    {
        return $this->select('beli_detail.ID_Beli, us.ID_Pengguna ID_Pengguna, us.Nama_Pengguna, s.created_at tgl_transaksi,p.ID_Produk, p.Nama_Produk, beli_detail.Total_Harga total')
            ->join('beli s', 'ID_Beli')
            ->join('pengguna us', 'us.ID_Pengguna = s.ID_Pengguna')
            ->join('produk p', 'ID_Produk')
            ->where('ID_Beli', $ID_Beli)
            ->findAll();
    }
}
