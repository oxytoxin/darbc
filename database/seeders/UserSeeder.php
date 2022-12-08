<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $release_admin = User::create([
            'first_name' => 'Mark John Lerry',
            'middle_name' => 'Acosta',
            'surname' => 'Casero',
            'username' => 'release-admin',
            'password' => Hash::make('password'),
        ]);

        $release_admin->roles()->attach(Role::RELEASE_ADMIN);

        $cashier = User::create([
            'first_name' => 'Johnrey',
            'surname' => 'Naceda',
            'username' => 'cashier',
            'password' => Hash::make('password'),
        ]);

        $cashier->roles()->attach(Role::CASHIER);

        $office_staff = User::create([
            'first_name' => 'Johnrex',
            'surname' => 'Naceda',
            'username' => 'office-staff',
            'password' => Hash::make('password'),
        ]);

        $office_staff->roles()->attach(Role::OFFICE_STAFF);

        $land_admin = User::create([
            'first_name' => 'Mogyahid',
            'surname' => 'Ansid',
            'username' => 'land-admin',
            'password' => Hash::make('password'),
        ]);

        $land_admin->roles()->attach(Role::LAND_ADMIN);
    }
}
