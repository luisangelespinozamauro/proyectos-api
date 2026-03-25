<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'role_id' => 1,
                'collaborator_number' => '250852',
                'name' => 'Luis Angel',
                'last_name' => 'Espinoza Mauro',
                'phone' => null,
                'email' => 'luis.espinoza@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 2,
                'collaborator_number' => '000001',
                'name' => 'RAUL',
                'last_name' => 'TELLEZ',
                'phone' => null,
                'email' => 'raul.tellez@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 2,
                'collaborator_number' => '240374',
                'name' => 'JAVIER',
                'last_name' => 'RODRIGUEZ MURRIETA',
                'phone' => '3316026901',
                'email' => 'javier.rodriguez@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 2,
                'collaborator_number' => '240352',
                'name' => 'ISAAC',
                'last_name' => 'GOMEZ FLORES',
                'phone' => '3318250781',
                'email' => 'isaac.gomezf@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 3,
                'collaborator_number' => '240498',
                'name' => 'MARIO ALVARO',
                'last_name' => 'PEREZ GONZALEZ',
                'phone' => '3316998614',
                'email' => 'mario.perez@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 3,
                'collaborator_number' => '250869',
                'name' => 'MIGUEL ANGEL',
                'last_name' => 'VALLEJO ALVAREZ',
                'phone' => '3334940437',
                'email' => 'miguel.vallejo@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 3,
                'collaborator_number' => '220039',
                'name' => 'JOSE FRANCISCO',
                'last_name' => 'CHAVEZ RIVERA',
                'phone' => '3310185105',
                'email' => 'francisco.chavez@ldrsolutions.com.mx',
            ],
            [
                'role_id' => 3,
                'collaborator_number' => '250871',
                'name' => 'SALVADOR EXIQUIO',
                'last_name' => 'CHAVEZ NAVARRO',
                'phone' => '3332501819',
                'email' => 'salvador.chavez@ldrsolutions.com.mx',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                ...$user,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
