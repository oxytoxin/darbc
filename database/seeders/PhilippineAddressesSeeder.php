<?php

namespace Database\Seeders;

use App;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhilippineAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding regions!');
        DB::unprepared(file_get_contents(database_path('ph_addresses/regions.sql')));
        $this->command->info('Regions seeded!');
        $this->command->info('Seeding provinces!');
        DB::unprepared(file_get_contents(database_path('ph_addresses/provinces.sql')));
        $this->command->info('Provinces seeded!');
        $this->command->info('Seeding cities!');
        DB::unprepared(file_get_contents(database_path('ph_addresses/cities.sql')));
        $this->command->info('Cities seeded!');
        $this->command->info('Seeding barangays!');
        if (App::isProduction()) {
            DB::unprepared(file_get_contents(database_path('ph_addresses/barangays.sql')));
        } else {
            DB::unprepared(file_get_contents(database_path('ph_addresses/barangays-test.sql')));
        }
        $this->command->info('Barangays seeded!');
    }
}
