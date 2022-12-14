<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $member = [];
        for ($i=0; $i < 100; $i++) { 
            $member[] = [
                'kode' => "M-" . sprintf("%05s", ($i +1)),
                'nama' => $faker->name,
                'alamat' => $faker->address,
            ];
        }
        Member::insert($member);
    }
}
