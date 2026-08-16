<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed order follows migration foreign keys (parents before children).
     */
    public function run(): void
    {
        $this->call([
            GeographySeeder::class,
            PermissionsRolesAndUsersSeeder::class,
            UsersSeeder::class,
            CategoriesSeeder::class,
            PlansCouponsSeeder::class,
            SettingsSeeder::class,
            BlogPostsSeeder::class,
            PropertiesSeeder::class,
            SubscriptionsAndPaymentsSeeder::class,
            UserEngagementSeeder::class,
            ContentAndNotificationsSeeder::class,
        ]);
    }
}
