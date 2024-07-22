<?php

namespace App\Models;

use CodeIgniter\Model;

class BerandaModel extends Model
{
    public function showChartTransaksi($tahun)
    {
        return $this->db->table('transaksi_detail as td')
            ->select('MONTH(t.Tanggal_Transaksi) month, SUM(td.Total_Harga) total')
            ->join('transaksi t', 'No_Transaksi')
            ->where('YEAR(t.Tanggal_Transaksi)', $tahun)
            ->groupBy('MONTH(t.Tanggal_Transaksi)')
            ->orderBy('MONTH(t.Tanggal_Transaksi)')
            ->get()->getResultArray();
    }

    public function showChartPelanggan($tahun)
    {
        return $this->db->table('pelanggan')
            ->select('MONTH(created_at) month, COUNT(*) total')
            ->where('YEAR(created_at)', $tahun)
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)')
            ->get()->getResultArray();
    }

    public function showChartPembelian($tahun)
    {
        return $this->db->table('beli_detail as bd')
            ->select('MONTH(b.created_at) month, SUM(bd.Total_Harga) total')
            ->join('beli b', 'ID_Beli')
            ->where('YEAR(b.created_at)', $tahun)
            ->orderBy('MONTH(b.created_at)')
            ->get()->getResultArray();
    }

    public function showChartProduk($tahun)
    {
        return $this->db->table('produk')
            ->select('MONTH(Tanggalexp) month, COUNT(*) total')
            ->where('YEAR(Tanggalexp)', $tahun)
            ->groupBy('MONTH(Tanggalexp)')
            ->orderBy('MONTH(Tanggalexp)')
            ->get()->getResultArray();
    }
}
