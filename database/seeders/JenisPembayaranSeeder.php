<?php

namespace Database\Seeders;

use App\Models\JenisPembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JenisPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $jenis_pembayaran = [];
        $data = ['BRI', 'BCA', 'BNI', 'BTN', 'MANDIRI', 'PANIN'];
        $jenis_pembayaran[] = [
            'jenis' => 'TUNAI',
            'no_rek' => '-',
        ];
        foreach ($data as $key => $value) {
            $jenis_pembayaran[] = [
                'jenis' => $value,
                'no_rek' => $faker->creditCardNumber()
            ];
        }
        JenisPembayaran::insert($jenis_pembayaran);
    }
}
