<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    // Mana Tabel
    protected $table            = 'layanan';
    protected $primaryKey       = 'ID_Layanan';
    protected $allowedFields    = [
        'Nama_Layanan', 'Harga_Layanan', 'ID_Kategori_Layanan'  
    ];
    protected $useSoftDeletes = true;


    public function getLayanan($ID_Layanan = false)
    {
        $query = $this->table('layanan')
            ->join('kategori_layanan', 'ID_Kategori_Layanan')
            ->where('deleted_at is null');
        // ->join('Produk', 'ID_Produk', 'right');

        if ($ID_Layanan == false)
            return $query->get()->getResultArray();
        return $query->where(['ID_Layanan' => $ID_Layanan])->first();
    }
}
