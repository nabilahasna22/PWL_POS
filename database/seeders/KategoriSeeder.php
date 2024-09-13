<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 1,
                'kategoi_nama' => 'Makanan',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 2,
                'kategoi_nama' => 'Kecantikan dan Personal Care',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 3,
                'kategoi_nama' => 'Minuman',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 4,
                'kategoi_nama' => 'Produk Kesehatan',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 5,
                'kategoi_nama' => 'Kebutuhan Rumah Tangga',
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}