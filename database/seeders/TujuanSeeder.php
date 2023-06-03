<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TujuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('tujuans')->insert([
        [ 'negara_tujuan' => 'HONGKONG'],
        [ 'negara_tujuan' => 'TAIWAN'],
        [ 'negara_tujuan' => 'SINGAPURA'],
        [ 'negara_tujuan' => 'MALAYSIA'],
        [ 'negara_tujuan' => 'KOREA'],
        [ 'negara_tujuan' => 'JEPANG'],
        [ 'negara_tujuan' => 'ARAB'],
        [ 'negara_tujuan' => 'NULL'],


        ]);
    }
}
