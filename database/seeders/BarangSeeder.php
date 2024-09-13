<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'M1',
                'barang_nama' => 'Pop Mie',
                'harga_beli' => 5500,
                'harga_jual' => 6000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'M2',
                'barang_nama' => 'Beng Beng',
                'harga_beli' => 1500,
                'harga_jual' => 2000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'M3',
                'barang_nama' => 'Aoka',
                'harga_beli' => 2000,
                'harga_jual' => 2500
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 1,
                'barang_kode' => 'M4',
                'barang_nama' => 'Chitato',
                'harga_beli' => 9000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 1,
                'barang_kode' => 'M5',
                'barang_nama' => 'Sosis',
                'harga_beli' => 7000,
                'harga_jual' => 8000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 2,
                'barang_kode' => 'KO1',
                'barang_nama' => 'Sunscreen',
                'harga_beli' => 33000,
                'harga_jual' => 35000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'KO2',
                'barang_nama' => 'Liptint',
                'harga_beli' => 18000,
                'harga_jual' => 20000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 2,
                'barang_kode' => 'KO3',
                'barang_nama' => 'Body Lotion',
                'harga_beli' => 28000,
                'harga_jual' => 30000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'K1',
                'barang_nama' => 'Minyak Kayu Putih',
                'harga_beli' => 10000,
                'harga_jual' => 12000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'K2',
                'barang_nama' => 'Vitamin C',
                'harga_beli' => 6500,
                'harga_jual' => 7000,
            ],
            [
                'barang_id' => 11,
                'kategori_id' => 3,
                'barang_kode' => 'E1',
                'barang_nama' => 'Kabel Olor',
                'harga_beli' => 28000,
                'harga_jual' => 30000,
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 3,
                'barang_kode' => 'E2',
                'barang_nama' => 'Baterai',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
            ], 
            [
                'barang_id' => 13,
                'kategori_id' => 5,
                'barang_kode' => 'P1',
                'barang_nama' => 'Kursi Lipat',
                'harga_beli' => 72000,
                'harga_jual' => 75000,
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 5,
                'barang_kode' => 'P2',
                'barang_nama' => 'Meja Lipat',
                'harga_beli' => 47000,
                'harga_jual' => 50000,
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 5,
                'barang_kode' => 'P3',
                'barang_nama' => 'Payung',
                'harga_beli' => 23000,
                'harga_jual' => 25000,
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
