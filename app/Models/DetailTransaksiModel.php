<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'transaksi_detail';
    protected $allowedFields = ['No_Transaksi', 'ID_Layanan', 'ID_Produk', 'Harga', 'Jumlah', 'Total_Harga'];
}
