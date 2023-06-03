<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_updates')->insert([
            [ 'status_update' => 'BARU'],
            [ 'status_update' => 'PRA MEDICAL'],
            [ 'status_update' => 'ID PMI'],
            [ 'status_update' => 'PRA BPJS'],
            [ 'status_update' => 'REKOM PERPEN'],
            [ 'status_update' => 'MEDICAL FULL'],
            [ 'status_update' => 'BLK'],
            [ 'status_update' => 'PASPOR'],
            [ 'status_update' => 'UJK'],
            [ 'status_update' => 'MARKET'],
            [ 'status_update' => 'JOB'],
            [ 'status_update' => 'EC'],
            [ 'status_update' => 'VISA'],
            [ 'status_update' => 'BPJS PURNA'],
            [ 'status_update' => 'KTKLN'],
            [ 'status_update' => 'TERBANG'],
            [ 'status_update' => 'INVOICE TOYO'],
            [ 'status_update' => 'INVOICE AGENCY'],
            [ 'status_update' => 'PENDING'],
            [ 'status_update' => 'MD'],
            ]);
    }
}
