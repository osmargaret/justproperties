<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionsRolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $permissionSlugs = [
            ['name' => 'View users', 'slug' => 'view-users'],
            ['name' => 'Delete users', 'slug' => 'delete-users'],
            ['name' => 'Moderate user', 'slug' => 'moderate-user'],
            ['name' => 'View properties', 'slug' => 'view-properties'],
            ['name' => 'Delete property', 'slug' => 'delete-property'],
            ['name' => 'Moderate property', 'slug' => 'moderate-property'],
            ['name' => 'View post', 'slug' => 'view-post'],
            ['name' => 'Create post', 'slug' => 'create-post'],
            ['name' => 'Update post', 'slug' => 'update-post'],
            ['name' => 'Delete post', 'slug' => 'delete-post'],
            ['name' => 'Moderate post', 'slug' => 'moderate-post'],
            ['name' => 'View subscriptions', 'slug' => 'view-subscriptions'],
            ['name' => 'View promotions', 'slug' => 'view-promotions'],
            ['name' => 'View payments', 'slug' => 'view-payments'],
            ['name' => 'View coupons', 'slug' => 'view-coupons'],
            ['name' => 'Manage coupons', 'slug' => 'manage-coupons'],
            ['name' => 'Manage settings', 'slug' => 'manage-settings'],
            ['name' => 'Manage users', 'slug' => 'manage-users'],
            ['name' => 'Manage properties', 'slug' => 'manage-properties'],
            ['name' => 'Manage subscriptions', 'slug' => 'manage-subscriptions'],
            ['name' => 'Manage payments', 'slug' => 'manage-payments'],
            ['name' => 'Manage blog', 'slug' => 'manage-blog'],
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
                    'role_id' => $sellerRole->id,
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
