<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CashiersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "id" => 10718,
            "reference_name" => null,
            "first_name" => "Teller 1 Lyn ",
            "middle_name" => null,
            "surname" => "Galvan",
            "suffix" => null,
            "username" => "cashier1",
            "password" => '$2y$10$IUy/D79pfku8.a7YCMMzkufSeADEDMM7nCLVFwIyEqtxTQRZm9.C6',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10719,
            "reference_name" => null,
            "first_name" => "Teller 2 Shiela Mae",
            "middle_name" => null,
            "surname" => "Silvela",
            "suffix" => null,
            "username" => "cashier2",
            "password" => '$2y$10$P7KxByjN4yXNVT6H3CBiT.QgKntDZSsw06joz3R71jPhE7l1tnXD2',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10720,
            "reference_name" => null,
            "first_name" => "Teller 3 Zamantha Grace",
            "middle_name" => null,
            "surname" => "Urtado",
            "suffix" => null,
            "username" => "cashier3",
            "password" => '$2y$10$aXxb37L4xJND1aY1QseHYuLzumfd8r4oKXRuhyAnHwI9SX7NV50u.',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10721,
            "reference_name" => null,
            "first_name" => "Teller 4 Albert",
            "middle_name" => null,
            "surname" => "Boer",
            "suffix" => null,
            "username" => "cashier4",
            "password" => '$2y$10$/zd8rD.MLLx1.3RU1pH1veO2LrqsFYX3DhBItWHzSPJkw1AsMPHP.',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10722,
            "reference_name" => null,
            "first_name" => "Teller 5 Romeo Jr.",
            "middle_name" => null,
            "surname" => "Famales",
            "suffix" => null,
            "username" => "cashier5",
            "password" => '$2y$10$xrQkzjuT1dOJ0wzLhgDYkOpK4KpplGm8vo5kpuiJqZ2UIcpqgVXiK',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10723,
            "reference_name" => null,
            "first_name" => "Teller 6 Valentin",
            "middle_name" => null,
            "surname" => "Dideles",
            "suffix" => null,
            "username" => "cashier6",
            "password" => '$2y$10$SMZZc12X8K7CLOZTBgR52.0maa98I.e3R/xH9NgKn2MDXU.jOAiOy',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10724,
            "reference_name" => null,
            "first_name" => "Teller 7 Marnelle",
            "middle_name" => null,
            "surname" => "Malubay",
            "suffix" => null,
            "username" => "cashier7",
            "password" => '$2y$10$poSXV6np78jkAINCn4UVDeXfL.xl3o9utMiKNFm5rDaqbtSiEaOXS',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10725,
            "reference_name" => null,
            "first_name" => "Teller 8 Cherry Mae",
            "middle_name" => null,
            "surname" => "Campo",
            "suffix" => null,
            "username" => "cashier8",
            "password" => '$2y$10$xAuRYSepsxRui/pB1j.9peDv/IG4mWP2IhDDD6TLjbm52S3LlIUYi',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10726,
            "reference_name" => null,
            "first_name" => "Teller 9 Janelyn",
            "middle_name" => null,
            "surname" => "Muñez",
            "suffix" => null,
            "username" => "cashier9",
            "password" => '$2y$10$RAQCQEyo4VFXiY/WZeVqRO781/luZYdhmUHc4iBApV8dM/sktVonu',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10727,
            "reference_name" => null,
            "first_name" => 'Teller 10 Lyn "D"',
            "middle_name" => null,
            "surname" => "Ramo",
            "suffix" => null,
            "username" => "cashier10",
            "password" => '$2y$10$LHcQNNlWSMjq4dyiTBgYTOWGf/UGqhmJl3W3xRyvR7fbSKv2/JQJW',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10728,
            "reference_name" => null,
            "first_name" => "Teller 11 Loryve",
            "middle_name" => null,
            "surname" => "Bentolan",
            "suffix" => null,
            "username" => "cashier11",
            "password" => '$2y$10$.udXfjaj4fE2h23mPZMCwu0yjsBQX0pomn5KfBuwf52D2vonuAG42',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10729,
            "reference_name" => null,
            "first_name" => "Teller 12 Brian",
            "middle_name" => null,
            "surname" => "Caraballe",
            "suffix" => null,
            "username" => "cashier12",
            "password" => '$2y$10$USVk4qGobgZ.32lQSfinz.tNMCLJzz5Sxh4T3c6lUdMgDZSNV1XdS',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10730,
            "reference_name" => null,
            "first_name" => "Teller 13 Leniel",
            "middle_name" => null,
            "surname" => "Mantilla",
            "suffix" => null,
            "username" => "cashier13",
            "password" => '$2y$10$80MW5du1YofiiA/6NAOFLO82AxISSdVEDhfosu1fpbn44u26M5hOK',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10731,
            "reference_name" => null,
            "first_name" => "Teller 14 Raffy",
            "middle_name" => null,
            "surname" => "Mejares",
            "suffix" => null,
            "username" => "cashier14",
            "password" => '$2y$10$BEeIX04.klx0FAuNWaF.Fe2fOxp7qKZsKsujtmKS1eRxX/0YueKtq',
        ]);
        $user->roles()->attach(Role::find(2));
        $user = User::create([
            "id" => 10732,
            "reference_name" => null,
            "first_name" => "Teller 15 Jestoni",
            "middle_name" => null,
            "surname" => "Cuyos",
            "suffix" => null,
            "username" => "cashier15",
            "password" => '$2y$10$vL6P/NufnYgKYdQTzUjkCuzBydn4XQ4JIwRV5kG1..VzUKi9jeal6',
        ]);
        $user->roles()->attach(Role::find(2));
    }
}
