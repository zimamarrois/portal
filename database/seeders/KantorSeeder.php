<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kantors')->insert([
            [ 'kantor' => 'KANTOR PUSAT'],
            [ 'kantor' => 'KANTOR CABANG 1'],
            [ 'kantor' => 'KANTOR CABANG 2'],
            [ 'kantor' => 'KANTOR PEMBANTU'],
        ]);
    }
}
