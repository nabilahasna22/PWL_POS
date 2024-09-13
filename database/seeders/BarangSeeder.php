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
            // Barang dari Indofood (kategori makanan)
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'I01',
                'barang_nama' => 'Indomie Goreng',
                'harga_beli' => '2300',
                'harga_jual' => '3500',
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'I02',
                'barang_nama' => 'Indomie Kuah Ayam Bawang',
                'harga_beli' => '2300',
                'harga_jual' => '3500',
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'I03',
                'barang_nama' => 'Chitato Sapi Panggang',
                'harga_beli' => '8000',
                'harga_jual' => '10000',
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 1,
                'barang_kode' => 'I04',
                'barang_nama' => 'Pop Mie Kari Ayam',
                'harga_beli' => '5500',
                'harga_jual' => '7500',
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 1,
                'barang_kode' => 'I05',
                'barang_nama' => 'Indomilk UHT Cokelat',
                'harga_beli' => '4500',
                'harga_jual' => '6000',
            ],

            // Barang dari Unilever (kategori kecantikan dan personal care)
            [
                'barang_id' => 6,
                'kategori_id' => 2,
                'barang_kode' => 'U01',
                'barang_nama' => 'Lifebuoy Total 10 Sabun Cair',
                'harga_beli' => '12000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'U02',
                'barang_nama' => 'Sunsilk Black Shine Sampo',
                'harga_beli' => '18000',
                'harga_jual' => '22000',
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 2,
                'barang_kode' => 'U03',
                'barang_nama' => 'Rexona Men Roll On',
                'harga_beli' => '15000',
                'harga_jual' => '20000',
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 2,
                'barang_kode' => 'U04',
                'barang_nama' => 'Dove Moisturizing Cream',
                'harga_beli' => '25000',
                'harga_jual' => '32000',
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 2,
                'barang_kode' => 'U05',
                'barang_nama' => 'Pepsodent Pasta Gigi',
                'harga_beli' => '8000',
                'harga_jual' => '12000',
            ],

            // Barang dari Kalbe Farma (kategori produk kesehatan)
            [
                'barang_id' => 11,
                'kategori_id' => 3,
                'barang_kode' => 'K01',
                'barang_nama' => 'Prenagen Esensis Cokelat',
                'harga_beli' => '35000',
                'harga_jual' => '45000',
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 3,
                'barang_kode' => 'K02',
                'barang_nama' => 'Hydro Coco',
                'harga_beli' => '5000',
                'harga_jual' => '7000',
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 3,
                'barang_kode' => 'K03',
                'barang_nama' => 'Fatigon Spirit',
                'harga_beli' => '12000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 3,
                'barang_kode' => 'K04',
                'barang_nama' => 'Mixagrip Flu & Batuk',
                'harga_beli' => '4000',
                'harga_jual' => '6000',
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 3,
                'barang_kode' => 'K05',
                'barang_nama' => 'Zee Vanilla Milk',
                'harga_beli' => '3000',
                'harga_jual' => '5000',
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
