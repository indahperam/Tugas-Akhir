<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuan = ['pak','lusin','kodi','kardus','pcs'];
        foreach ($satuan as $key => $value) {
            Satuan::create([
                'nama' => $value
            ]);
        }
    }
}
