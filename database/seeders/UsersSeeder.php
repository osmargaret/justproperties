<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');
        $countryId = Country::query()->where('code', 'NG')->value('id');
        $staffRole = Role::query()->where('slug', 'staff')->value('id');

        $users = [
            [
                'email' => 'seller1@example.com',
                'name' => 'Tunde Bakare',
                'active_role' => 'seller',
                'phone' => '+2348011111111',
            ],
            [
                'email' => 'seller2@example.com',
                'name' => 'Chioma Nwachukwu',
                'active_role' => 'seller',
                'phone' => '+2348022222222',
            ],
            [
                'email' => 'seller3@example.com',
                'name' => 'Abubakar Musa',
                'active_role' => 'seller',
                'phone' => '+2348033333333',
            ],
            [
                'email' => 'seller4@example.com',
                'name' => 'Funmi Adebayo',
                'active_role' => 'seller',
                'phone' => '+2348044444444',
            ],
            [
                'email' => 'buyer1@example.com',
                'name' => 'Emeka Okafor',
                'active_role' => 'buyer',
                'phone' => '+2348055555555',
            ],
            [
                'email' => 'buyer2@example.com',
                'name' => 'Fatima Yusuf',
                'active_role' => 'buyer',
                'phone' => '+2348066666666',
            ],
            [
                'email' => 'buyer3@example.com',
                'name' => 'Kofi Mensah',
                'active_role' => 'buyer',
                'phone' => '+2348077777777',
            ],
            [
                'email' => 'buyer4@example.com',
                'name' => 'Yetunde Balogun',
                'active_role' => 'buyer',
                'phone' => '+2348088888888',
            ],
            [
                'email' => 'staff1@example.com',
                'name' => 'Staff Agent John',
                'active_role' => 'admin',
                'role_id' => $staffRole,
                'phone' => '+2348099999999',
            ],
            [
                'email' => 'staff2@example.com',
                'name' => 'Staff Support Jane',
                'active_role' => 'admin',
                'role_id' => $staffRole,
                'phone' => '+2348099999990',
            ],
        ];

        foreach ($users as $u) {
            User::query()->updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => $password,
                    'email_verified_at' => now(),
                    'two_factor_enable' => false,
                    'role_id' => $u['role_id'] ?? null,
                    'active_role' => $u['active_role'],
                    'phone' => $u['phone'],
                    'country_id' => $countryId,
                ]
            );
        }
    }
}
