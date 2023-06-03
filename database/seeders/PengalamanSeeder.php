<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengalamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengalamen')->insert([
            [ 'pengalaman' => 'NON'],
            [ 'pengalaman' => 'EXS HONGKONG'],
            [ 'pengalaman' => 'EXS TAIWAN'],
            [ 'pengalaman' => 'EXS SINGAPURA'],
            [ 'pengalaman' => 'EXS MALAYSIA'],
            [ 'pengalaman' => 'EXS KOREA'],
            [ 'pengalaman' => 'EXS JEPANG'],
            [ 'pengalaman' => 'EXS ARAB'],
    
    
            ]);
    }
}
