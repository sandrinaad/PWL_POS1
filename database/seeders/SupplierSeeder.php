<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'A',
                'supplier_nama' => 'Supplier A',
                'supplier_alamat' => 'Jl Mawar',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'B',
                'supplier_nama' => 'Supplier B',
                'supplier_alamat' => 'Jl Melati',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'C',
                'supplier_nama' => 'Supplier C',
                'supplier_alamat' => 'Jl Anggrek'
            ]
        ];
        DB::table('m_supplier')->insert($data);
    }
}
