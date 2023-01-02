<?php

namespace Database\Seeders;

use App\Models\JenisPembayaran;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClosingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $produk = Produk::all();
        $jenis_pembayaran = JenisPembayaran::all();

        $transaksi = [];
        $transaksi_detail = [];
        $pembayaran = [];
        for ($kode = 0; $kode < 1000; $kode++) {
            $harga = 0;
            for ($i = 0; $i < 10; $i++) {
                $dummy_produk = $produk[(rand(1, 50))];
                $jumlah = rand(1, 10);
                $harga_jual = $dummy_produk->harga_jual;
                $subtotal = $jumlah * $dummy_produk->harga_jual;
                $transaksi_detail[] = [
                    'transaksi_id' => $kode + 1,
                    'kode' => $dummy_produk->kode,
                    'nama' => $dummy_produk->nama,
                    'harga_jual' => $harga_jual,
                    'subtotal' => $subtotal,
                    'jumlah' => $jumlah,
                ];
                $harga += $subtotal;
            }

            $diskon = rand(0, 100) / 100;
            $diskon_total = $diskon * $harga;

            $ppn = 11 / 100;
            $ppn_total = $ppn * ($harga - $diskon_total);

            $grand_total = ($harga - $diskon_total) - $ppn_total;
            $status = ['lunas', 'belum lunas'];
            $lunas = $status[rand(0, 1)];
            $active = false;

            $transaksi[] = [
                'kode' => "TR-" . sprintf("%05s", $kode + 1),
                'member_id' => rand(0, 25),
                'total' => $harga,
                'diskon' => $diskon,
                'diskon_total' => $diskon_total,
                'ppn' => $ppn,
                'ppn_total' => $ppn_total,
                'grand_total' => $grand_total,
                'lunas' => $lunas,
                'active' => $active,
                'created_at' => $faker->dateTimeBetween('-1 week', '+1 week'),
            ];
            if ($lunas == 'lunas') {
                $pembayaran[] = [
                    'transaksi_id' => $kode + 1,
                    'tipe' => 'TUNAI',
                    'nominal' => $grand_total,
                ];
            }
        }
        Transaksi::insert($transaksi);
        TransaksiDetail::insert($transaksi_detail);
        Pembayaran::insert($pembayaran);
    }
}
