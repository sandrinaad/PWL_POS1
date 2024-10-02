<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'barang_kode'; // Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['barang_kode', 'kategori_id', 'barang_nama', 'harga_beli', 'harga_jual']; // Mendefinisikan kolom yang dapat diisi secara massal
}
