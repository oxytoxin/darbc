<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Artisan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(OccupationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClusterSeeder::class);
        $this->call(MembershipStatusSeeder::class);
        $this->call(PhilippineAddressesSeeder::class);
        // $this->call(MemberInformationSeeder::class);
        $this->command->call('seed:members');
        $this->command->call('seed:extra');
        $this->command->call('seed:spa');
    }
}
