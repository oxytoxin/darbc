<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Artisan;
use Illuminate\Database\Seeder;
use Database\Seeders\RsbsaRoleSeeder;

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
        $this->call(CashiersSeeder::class);
        $this->command->call('seed:members');
        $this->command->call('seed:extra');
        $this->command->call('seed:spa');
        $this->command->call('seed:unclaimed_releases');
        $this->command->call('seed:unclaimed_shares');
        $this->call(ReleaseSeeder::class);

        $this->call(BlockAddressSeeder::class);
        $this->call(LotAddressSeeder::class);
        $this->call(AreaAddressSeeder::class);
        $this->call(LotInformationSeeder::class);
        $this->call(RsbsaRoleSeeder::class);
    }
}
