<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Penjualan ID 1
            [
                'detail_id' => 1,
                'penjualan_id' => 1,
                'barang_id' => 1, // Indomie Goreng
                'harga' => '3500',
                'jumlah' => '10',
            ],
            [
                'detail_id' => 2,
                'penjualan_id' => 1,
                'barang_id' => 2, // Indomie Kuah Ayam Bawang
                'harga' => '3500',
                'jumlah' => '5',
            ],
            [
                'detail_id' => 3,
                'penjualan_id' => 1,
                'barang_id' => 3, // Chitato Sapi Panggang
                'harga' => '10000',
                'jumlah' => '3',
            ],

            // Penjualan ID 2
            [
                'detail_id' => 4,
                'penjualan_id' => 2,
                'barang_id' => 4, // Pop Mie Kari Ayam
                'harga' => '7500',
                'jumlah' => '6',
            ],
            [
                'detail_id' => 5,
                'penjualan_id' => 2,
                'barang_id' => 5, // Indomilk UHT Cokelat
                'harga' => '6000',
                'jumlah' => '8',
            ],
            [
                'detail_id' => 6,
                'penjualan_id' => 2,
                'barang_id' => 6, // Lifebuoy Total 10 Sabun Cair
                'harga' => '15000',
                'jumlah' => '4',
            ],

            // Penjualan ID 3
            [
                'detail_id' => 7,
                'penjualan_id' => 3,
                'barang_id' => 7, // Sunsilk Black Shine Sampo
                'harga' => '22000',
                'jumlah' => '2',
            ],
            [
                'detail_id' => 8,
                'penjualan_id' => 3,
                'barang_id' => 8, // Rexona Men Roll On
                'harga' => '20000',
                'jumlah' => '6',
            ],
            [
                'detail_id' => 9,
                'penjualan_id' => 3,
                'barang_id' => 9, // Dove Moisturizing Cream
                'harga' => '32000',
                'jumlah' => '3',
            ],

            // Penjualan ID 4
            [
                'detail_id' => 10,
                'penjualan_id' => 4,
                'barang_id' => 10, // Pepsodent Pasta Gigi
                'harga' => '12000',
                'jumlah' => '10',
            ],
            [
                'detail_id' => 11,
                'penjualan_id' => 4,
                'barang_id' => 11, // Prenagen Esensis Cokelat
                'harga' => '45000',
                'jumlah' => '2',
            ],
            [
                'detail_id' => 12,
                'penjualan_id' => 4,
                'barang_id' => 12, // Hydro Coco
                'harga' => '7000',
                'jumlah' => '20',
            ],

            // Penjualan ID 5
            [
                'detail_id' => 13,
                'penjualan_id' => 5,
                'barang_id' => 13, // Fatigon Spirit
                'harga' => '15000',
                'jumlah' => '5',
            ],
            [
                'detail_id' => 14,
                'penjualan_id' => 5,
                'barang_id' => 14, // Mixagrip Flu & Batuk
                'harga' => '6000',
                'jumlah' => '10',
            ],
            [
                'detail_id' => 15,
                'penjualan_id' => 5,
                'barang_id' => 15, // Zee Vanilla Milk
                'harga' => '5000',
                'jumlah' => '15',
            ],
        ];

        DB::table('t_penjualan_detail')->insert($data);
    }
}
