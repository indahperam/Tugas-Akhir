<?php

namespace Database\Seeders;

use App\Models\Kategori;
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
        for ($i = 0; $i < 100; $i++) {
            $harga_beli = rand(10, 100) * 1000;
            $produk = Produk::create([
                'nama' => 'produk ' . $i,
                'kategori_id' => 1,
                'satuan_id' => 1,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_beli + 10000,
                'stok' => rand(10, 20),
            ]);
            $produk->kode = "P-" . sprintf("%05s", $produk->id);
            $produk->update();
        }
    }
}
