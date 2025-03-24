<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RsbsaRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Rsbsa Officer',
        ]);

        if (app()->environment('local')) {

            $rsbsa_officer = User::create([
                'first_name' => 'Juan ',
                'surname' => 'Delacruz',
                'username' => 'rsbsaofficer',
                'password' => Hash::make('Admindarbc1988'),
            ]);

            $rsbsa_officer->roles()->attach(Role::RSBSA_OFFICER);

        }

    }
}
