<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Stok barang dari Indofood (supplier_id 1)
            [
                'stok_id' => 1,
                'supplier_id' => 1,
                'barang_id' => 1, // Indomie Goreng
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 500,
            ],
            [
                'stok_id' => 2,
                'supplier_id' => 1,
                'barang_id' => 2, // Indomie Kuah Ayam Bawang
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 400,
            ],
            [
                'stok_id' => 3,
                'supplier_id' => 1,
                'barang_id' => 3, // Chitato Sapi Panggang
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 250,
            ],
            [
                'stok_id' => 4,
                'supplier_id' => 1,
                'barang_id' => 4, // Pop Mie Kari Ayam
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 300,
            ],
            [
                'stok_id' => 5,
                'supplier_id' => 1,
                'barang_id' => 5, // Indomilk UHT Cokelat
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 200,
            ],

            // Stok barang dari Unilever (supplier_id 2)
            [
                'stok_id' => 6,
                'supplier_id' => 2,
                'barang_id' => 6, // Lifebuoy Total 10 Sabun Cair
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 150,
            ],
            [
                'stok_id' => 7,
                'supplier_id' => 2,
                'barang_id' => 7, // Sunsilk Black Shine Sampo
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 200,
            ],
            [
                'stok_id' => 8,
                'supplier_id' => 2,
                'barang_id' => 8, // Rexona Men Roll On
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 180,
            ],
            [
                'stok_id' => 9,
                'supplier_id' => 2,
                'barang_id' => 9, // Dove Moisturizing Cream
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 140,
            ],
            [
                'stok_id' => 10,
                'supplier_id' => 2,
                'barang_id' => 10, // Pepsodent Pasta Gigi
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 300,
            ],

            // Stok barang dari Kalbe Farma (supplier_id 3)
            [
                'stok_id' => 11,
                'supplier_id' => 3,
                'barang_id' => 11, // Prenagen Esensis Cokelat
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 12,
                'supplier_id' => 3,
                'barang_id' => 12, // Hydro Coco
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 200,
            ],
            [
                'stok_id' => 13,
                'supplier_id' => 3,
                'barang_id' => 13, // Fatigon Spirit
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 80,
            ],
            [
                'stok_id' => 14,
                'supplier_id' => 3,
                'barang_id' => 14, // Mixagrip Flu & Batuk
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 500,
            ],
            [
                'stok_id' => 15,
                'supplier_id' => 3,
                'barang_id' => 15, // Zee Vanilla Milk
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 60,
            ],
        ];

        DB::table('t_stok')->insert($data);
    }
}
