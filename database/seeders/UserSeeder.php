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
            'first_name' => 'MARK JOHN LERRY',
            'middle_name' => 'ACOSTA',
            'surname' => 'CASERO',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $release_admin->roles()->attach(Role::RELEASE_ADMIN);

        $cashier = User::create([
            'first_name' => 'JOHNREY',
            'surname' => 'NACEDA',
            'username' => 'cashier',
            'password' => Hash::make('password'),
        ]);

        $cashier->roles()->attach(Role::CASHIER);

        $office_staff = User::create([
            'first_name' => 'JOHNREX',
            'surname' => 'NACEDA',
            'username' => 'office-staff',
            'password' => Hash::make('password'),
        ]);

        $office_staff->roles()->attach(Role::OFFICE_STAFF);

        $land_admin = User::create([
            'first_name' => 'MOGYAHID',
            'surname' => 'ANSID',
            'username' => 'land-admin',
            'password' => Hash::make('password'),
        ]);

        $land_admin->roles()->attach(Role::LAND_ADMIN);
    }
}
