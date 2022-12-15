<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $supplier = [];
        for ($i = 0; $i < 100; $i++) {
            $supplier[] = [
                'kode' => "M-" . sprintf("%05s", ($i + 1)),
                'nama' => $faker->name,
                'alamat' => $faker->address,
            ];
        }
        Supplier::insert($supplier);
    }
}
