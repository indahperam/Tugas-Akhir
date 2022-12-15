<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $data = ['BRI', 'BCA', 'BNI', 'BTN', 'MANDIRI', 'PANIN'];
        $pengeluaran = [];
        for ($i = 0; $i < 100; $i++) {
            $pengeluaran[] = [
                'kode' => "PN-" . sprintf("%05s", ($i + 1)),
                'jenis_transaksi' => "BTN",
                'nominal' => rand(1, 100) * 100000,
                'keterangan' => '-',
                'tanggal_input' => $faker->dateTimeBetween('-1 week', '+2 week')
            ];
        }
        Pengeluaran::insert($pengeluaran);
    }
}
