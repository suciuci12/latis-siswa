<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lembaga;


class LembagaSeeder extends Seeder
{

    public function run()
    {
       Lembaga::insert([
        ['nama' => 'Latiseducation'],
        ['nama' => 'Tutorindonesia'],
    ]);
    }
}
