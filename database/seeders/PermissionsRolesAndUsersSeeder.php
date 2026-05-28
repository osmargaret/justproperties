<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionsRolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {

        $now = now();
        $password = Hash::make('password');
        $nigeriaId = Country::query()->where('code', 'NG')->value('id');

        User::unguarded(function () use ($password, $now, $nigeriaId) {
            $adminRole = Role::query()->updateOrCreate(
                ['slug' => 'super-admin'],
                [
                    'name' => 'Super Admin',
                    'slug' => 'super-admin',
                    'users_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'subscriptions_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'promotions_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'properties_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'posts_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'payments_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'coupons_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                    'settings_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
                ]
            );
            User::query()->updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'password' => $password,
                    'email_verified_at' => $now,
                    'two_factor_enable' => false,
                    'role_id' => $adminRole->id,
                    'active_role' => 'admin',
                    'phone' => '+2348000000001',
                    'country_id' => $nigeriaId,
                ]
            );

            User::query()->updateOrCreate(
                ['email' => 'seller@example.com'],
                [
                    'name' => 'Demo Seller',
                    'password' => $password,
                    'email_verified_at' => $now,
                    'two_factor_enable' => false,
                    'role_id' => null,
                    'active_role' => 'seller',
                    'phone' => '+2348000000002',
                    'country_id' => $nigeriaId,
                ]
            );

            User::query()->updateOrCreate(
                ['email' => 'buyer@example.com'],
                [
                    'name' => 'Demo Buyer',
                    'password' => $password,
                    'email_verified_at' => $now,
                    'two_factor_enable' => false,
                    'role_id' => null,
                    'active_role' => 'buyer',
                    'phone' => '+2348000000003',
                    'country_id' => $nigeriaId,
                ]
            );
        });
    }
}
