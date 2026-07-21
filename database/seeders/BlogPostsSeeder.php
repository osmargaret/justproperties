<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('active_role', 'admin')->first();
        if (!$admin) {
            $admin = User::query()->first();
        }

        // Get non-property categories for blog post categories
        $categories = Category::query()->where('is_property', false)->get();
        if ($categories->isEmpty()) {
            $categories = Category::query()->get();
        }

        $topics = [
            'Real Estate Investment Secrets',
            'How to Choose the Right Property',
            'Buying vs Renting in Nigeria',
            'Understanding Property Valuation',
            'Top Locations to Buy Land',
            'Tips for First-Time Homebuyers',
            'Navigating Land Title Documentation',
            'The Rise of Short-Let Apartments',
            'Managing Rental Property Remotely',
            'Negotiating Property Prices Like a Pro',
            'Interior Design Tips to Boost Value',
            'Smart Home Features to Install',
            'Avoiding Common Real Estate Scams',
            'Benefits of Off-Plan Investments',
            'Cost of Building a House in Lagos',
            'Green Building and Eco-Friendly Homes',
            'How to Sell Your Property Faster',
            'Impact of Infrastructure on Land Prices',
            'Co-Living Spaces: The Next Big Thing',
            'Tax Implications of Property Transactions'
        ];

        foreach ($topics as $index => $title) {
            $category = $categories->random();
            $slug = Str::slug($title) . '-' . ($index + 1);

            Post::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $admin->id,
                    'category_id' => $category->id,
                    'property_id' => null,
                    'title' => $title,
                    'excerpt' => 'A comprehensive guide explaining everything you need to know about ' . strtolower($title) . '.',
                    'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam.</p>',
                    'status' => 'published',
                    'published_at' => now()->subDays($index * 2),
                ]
            );
        }
    }
}
