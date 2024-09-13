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
                'supplier_kode' => 1,
                'supplier_nama' => 'Indofood',
                'supplier_alamat' => 'Jl. Jenderal Sudirman Kav. 76-78, Jakarta 12910, Indonesia',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 2,
                'supplier_nama' => 'Unilever Indonesia Tbk',
                'supplier_alamat' => ' Jl. BSD Boulevard Barat, BSD City, Tangerang 15345, Indonesia',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 3,
                'supplier_nama' => 'Kalbe Farma Tbk',
                'supplier_alamat' => 'Jl. Letjen Suprapto Kav. IV, Jakarta 10510, Indonesia ',
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
