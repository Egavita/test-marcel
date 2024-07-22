<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKeys = 'No_Transaksi';
    protected $useTimestamps = true;
    protected $allowedFields = ['No_Transaksi', 'ID_Pengguna', 'ID_Pelanggan', 'ID_Layanan', 'ID_Produk', 'Total_Harga', 'Tanggal_Transaksi'];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('transaksi_detail as dt')
            ->select('t.No_Transaksi, pengguna.ID_Pengguna, pengguna.Nama_Pengguna, pelanggan.ID_Pelanggan, pelanggan.Nama_Pelanggan, l.ID_Layanan, l.Nama_Layanan, p.ID_Produk, p.Nama_Produk, SUM(t.Total_Harga)')
            ->join('transaksi t', 'No_Transaksi')
            ->join('pengguna', 'us.id = s.user_id') //detail produk ke produk
            ->join('supplier c', 'supplier_id', 'left')
            ->where('date(t.created_at) >=', $tgl_awal)
            ->where('date(t.created_at) <=', $tgl_akhir)
            ->groupBy('s.buy_id')
            ->get()->getResultArray();
    }
}
