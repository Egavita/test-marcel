<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleDetailModel extends Model
{
    protected $table            = 'transaksi_detail';
    protected $allowedFields    = ['No_Transaksi', 'ID_Layanan', 'ID_Produk', 'Jumlah', 'Harga', 'Total_Harga'];

    public function getInvoice($No_Transaksi)
    {
        return $this->select('transaksi_detail.No_Transaksi, us.Nama_Pengguna, s.Tanggal_Transaksi tgl_transaksi, c.Nama_Pelanggan, l.Nama_Layanan, transaksi_detail.Total_Harga total')
            ->join('transaksi s', 'No_Transaksi')
            ->join('pengguna us', 'us.ID_Pengguna = s.ID_Pengguna')
            ->join('layanan l', 'ID_Layanan')
            ->join('pelanggan c', 'ID_Pelanggan', 'left')
            ->where('No_Transaksi', $No_Transaksi)
            ->findAll();
    }
}
