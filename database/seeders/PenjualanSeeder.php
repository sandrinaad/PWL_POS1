<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan')->insert([
            [
                'user_id' => 3,
                'pembeli' => 'Sandrina',
                'penjualan_kode' => 'SS01',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Sandrina',
                'penjualan_kode' => 'SS02',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Sandrina',
                'penjualan_kode' => 'SS03',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Athallia',
                'penjualan_kode' => 'SS04',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Dwi',
                'penjualan_kode' => 'SS05',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Andselma',
                'penjualan_kode' => 'SS06',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Marsya',
                'penjualan_kode' => 'SS07',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Marsya',
                'penjualan_kode' => 'SS08',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Marsya',
                'penjualan_kode' => 'SS09',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Ica',
                'penjualan_kode' => 'SS10',
                'penjualan_tanggal' => Carbon::now(),
            ],
        ]);
    }
}
