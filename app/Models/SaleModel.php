<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'transaksi';
    // protected $useTimestamps    = true;
    protected $allowedFields    = ['No_Transaksi', 'ID_Pengguna', 'ID_Pelanggan', 'Tanggal_Transaksi'];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('transaksi_detail as sd')
            ->select('s.No_Transaksi, s.Tanggal_Transaksi tgl_transaksi, us.ID_Pengguna ID_Pengguna, us.Nama_Pengguna,
            c.ID_Pelanggan, c.Nama_Pelanggan Nama_Pelanggan, l.ID_Layanan, l.Nama_Layanan, SUM(sd.Total_Harga) total')
            ->join('transaksi s', 'No_Transaksi')
            ->join('pengguna us', 'us.ID_Pengguna = s.ID_Pengguna')
            ->join('layanan l', 'ID_Layanan')
            ->join('pelanggan c', 'ID_Pelanggan', 'left')
            ->where('date(s.Tanggal_Transaksi) >=', $tgl_awal)
            ->where('date(s.Tanggal_Transaksi) <=', $tgl_akhir)
            ->groupBy('s.No_Transaksi')
            ->get()->getResultArray();
    }
}
