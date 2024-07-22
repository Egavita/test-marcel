<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyModel extends Model
{
    protected $table = 'beli';
    protected $useTimestamps = true;
    protected $allowedFields = ['ID_Beli', 'ID_Pengguna'];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('beli_detail as sd')
            ->select('s.ID_Beli, s.created_at tgl_transaksi, us.ID_Pengguna ID_Pengguna, us.Nama_Pengguna, p.ID_Produk, p.Nama_Produk, SUM(sd.Total_Harga) total')
            ->join('beli s', 'ID_Beli')
            ->join('produk p', 'ID_Produk')
            ->join('pengguna us', 'us.ID_Pengguna = s.ID_Pengguna')
            ->where('date(s.created_at) >=', $tgl_awal)
            ->where('date(s.created_at) <=', $tgl_akhir)
            ->groupBy('s.ID_Beli')
            ->get()->getResultArray();
    }
}
