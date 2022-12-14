<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produk = [];
        for ($i = 0; $i < 1000; $i++) {
            $harga_beli = rand(10, 100) * 1000;
            $produk[] = [
                'kode' => "P-" . sprintf("%05s", ($i +1)),
                'nama' => "produk ".($i+1),
                'kategori_id' => 1,
                'satuan_id' => 1,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_beli + 10000,
                'stok' => rand(10, 20),
            ];
        }
        Produk::insert($produk);
    }
}
