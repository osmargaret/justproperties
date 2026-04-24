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
            CategoriesSeeder::class,
            PlansCouponsSeeder::class,
            PropertiesMediaSeeder::class,
            SubscriptionsAndPaymentsSeeder::class,
            UserEngagementSeeder::class,
            ContentAndNotificationsSeeder::class,
        ]);
    }
}
