<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(TujuanSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PengalamanSeeder::class);
        $this->call(MarketingSeeder::class);
        $this->call(KantorSeeder::class);
        $this->call(IndoRegionSeeder::class);
        $this->call(PetugasSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(AgencySeeder::class);



        //---------------------------------------
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
