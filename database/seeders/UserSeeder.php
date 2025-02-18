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
            'first_name' => 'John Effie',
            'surname' => 'Belarma',
            'username' => 'admin',
            'password' => Hash::make('Admindarbc1988'),
        ]);
        $krelease_admin = User::create([
            'first_name' => 'Kristine',
            'surname' => 'Ampas',
            'username' => 'kristineadmin',
            'password' => Hash::make('Admindarbc1988'),
        ]);

        $release_admin->roles()->attach(Role::RELEASE_ADMIN);
        $release_admin->roles()->attach(Role::OFFICE_STAFF);
        $release_admin->roles()->attach(Role::CASHIER);

        $krelease_admin->roles()->attach(Role::RELEASE_ADMIN);
        $krelease_admin->roles()->attach(Role::OFFICE_STAFF);
        $krelease_admin->roles()->attach(Role::CASHIER);

        if (app()->environment('local')) {
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
        }
    }
}
