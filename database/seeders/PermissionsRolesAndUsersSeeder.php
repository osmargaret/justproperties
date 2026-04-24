<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionsRolesAndUsersSeeder extends Seeder
{
    /**
     * permissions → roles → users → role_users (matches migration FK order after users exist).
     */
    public function run(): void
    {
        $permissionSlugs = [
            ['name' => 'Manage users', 'slug' => 'manage-users'],
            ['name' => 'Manage properties', 'slug' => 'manage-properties'],
            ['name' => 'Manage subscriptions', 'slug' => 'manage-subscriptions'],
            ['name' => 'Manage payments', 'slug' => 'manage-payments'],
            ['name' => 'Manage blog', 'slug' => 'manage-blog'],
            ['name' => 'Manage settings', 'slug' => 'manage-settings'],
        ];

        $permissions = [];
        foreach ($permissionSlugs as $row) {
            $permissions[$row['slug']] = Permission::query()->updateOrCreate(
                ['slug' => $row['slug']],
                ['name' => $row['name']]
            );
        }

        $adminRole = Role::query()->updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'type' => 'admin',
                'permissions' => array_keys($permissions),
            ]
        );

        $sellerRole = Role::query()->updateOrCreate(
            ['slug' => 'verified-seller'],
            [
                'name' => 'Verified Seller',
                'type' => 'seller',
                'permissions' => [],
            ]
        );

        $now = now();
        $password = Hash::make('password');
        $nigeriaId = Country::query()->where('code', 'NG')->value('id');

        User::unguarded(function () use ($password, $now, $nigeriaId) {
            User::query()->updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'password' => $password,
                    'email_verified_at' => $now,
                    'two_factor_enable' => false,
                    'is_admin' => true,
                    'active_role' => 'buyer',
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
                    'is_admin' => false,
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
                    'is_admin' => false,
                    'active_role' => 'buyer',
                    'phone' => '+2348000000003',
                    'country_id' => $nigeriaId,
                ]
            );
        });

        $adminUser = User::query()->where('email', 'admin@example.com')->firstOrFail();

        RoleUser::query()->firstOrCreate(
            ['role_id' => $adminRole->id, 'user_id' => $adminUser->id],
            []
        );

        RoleUser::query()->firstOrCreate(
            ['role_id' => $sellerRole->id, 'user_id' => User::query()->where('email', 'seller@example.com')->firstOrFail()->id],
            []
        );
    }
}
