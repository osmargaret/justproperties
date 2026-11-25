<?php

namespace Database\Seeders;

use App\Models\AdvertisementPlan;
use App\Models\AdvertisementSpace;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvertisementCatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $ngn = Currency::query()->where('currency_code', 'NGN')->first();
        $usd = Currency::query()->where('currency_code', 'USD')->first();

        if (! $ngn || ! $usd) {
            throw new \RuntimeException('Run GeographySeeder before AdvertisementCatalogueSeeder.');
        }

        $spaces = [];
        foreach ($this->spaces() as $spaceData) {
            $spaces[$spaceData['slug']] = AdvertisementSpace::query()->updateOrCreate(
                ['slug' => $spaceData['slug']],
                $spaceData
            );
        }

        $individualPlans = [
            [
                'slug' => 'homepage-hero-weekly',
                'name' => 'Homepage Hero Banner',
                'space' => 'homepage-hero-banner',
                'format' => 'Top Leaderboard',
                'billing_quantity' => 1,
                'billing_period' => 'week',
                'ngn' => 35000,
                'usd' => 25,
            ],
            [
                'slug' => 'catalog-listing-weekly',
                'name' => 'Catalog & Listing Pages',
                'space' => 'catalog-listing-pages',
                'format' => 'Billboard Banner',
                'billing_quantity' => 1,
                'billing_period' => 'week',
                'ngn' => 25000,
                'usd' => 18,
            ],
            [
                'slug' => 'property-details-weekly',
                'name' => 'Property Details Page',
                'space' => 'property-details-page',
                'format' => 'Sticky Sidebar & Calculator Ad',
                'billing_quantity' => 1,
                'billing_period' => 'week',
                'ngn' => 20000,
                'usd' => 15,
            ],
            [
                'slug' => 'blog-sidebar-weekly',
                'name' => 'Blog & Article Sidebar',
                'space' => 'blog-article-sidebar',
                'format' => 'Skyscraper / In-Article',
                'billing_quantity' => 1,
                'billing_period' => 'week',
                'ngn' => 15000,
                'usd' => 10,
            ],
            [
                'slug' => 'newsletter-email-cpm',
                'name' => 'Newsletter & Email',
                'space' => 'newsletter-email',
                'format' => 'Sponsored Email Header',
                'billing_quantity' => 1000,
                'billing_period' => 'email',
                'ngn' => 30000,
                'usd' => 20,
            ],
            [
                'slug' => 'partner-directory-monthly',
                'name' => 'Partner Directory Listing',
                'space' => 'partner-directory-listing',
                'format' => 'Featured Directory Profile',
                'billing_quantity' => 1,
                'billing_period' => 'month',
                'ngn' => 50000,
                'usd' => 35,
            ],
        ];

        DB::transaction(function () use ($individualPlans, $ngn, $usd, $spaces): void {
            foreach ($individualPlans as $data) {
                $plan = AdvertisementPlan::query()->updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'name' => $data['name'],
                        'description' => $data['format'],
                        'billing_quantity' => $data['billing_quantity'],
                        'billing_period' => $data['billing_period'],
                        'impressions_included' => null,
                        'features' => [],
                        'is_active' => true,
                    ]
                );

                $plan->spaces()->sync([$spaces[$data['space']]->id => ['quantity' => 1]]);
                $this->syncPrices($plan, [
                    [$ngn, $data['ngn'], true],
                    [$usd, $data['usd'], false],
                ]);
            }

            $bundles = [
                [
                    'slug' => 'starter-package',
                    'name' => 'Starter Package',
                    'description' => 'Monthly bundle for one placement area spot.',
                    'billing_quantity' => 1,
                    'billing_period' => 'month',
                    'impressions_included' => 50000,
                    'features' => ['1 Placement Area Spot', 'Monthly Analytics Report'],
                    'ngn' => 150000,
                    'space_slugs' => [],
                ],
                [
                    'slug' => 'growth-package',
                    'name' => 'Growth Package',
                    'description' => 'Quarterly bundle with priority rotation and a custom call to action.',
                    'billing_quantity' => 3,
                    'billing_period' => 'month',
                    'impressions_included' => 180000,
                    'features' => [
                        '2 Placement Area Spots',
                        'Priority Rotator & Custom CTA',
                        'Save 15% vs Monthly',
                    ],
                    'ngn' => 380000,
                    'space_slugs' => [],
                ],
                [
                    'slug' => 'enterprise-partner',
                    'name' => 'Enterprise Partner',
                    'description' => 'Annual partnership with all placement spots and newsletter exposure.',
                    'billing_quantity' => 1,
                    'billing_period' => 'year',
                    'impressions_included' => 750000,
                    'features' => [
                        'All 6 Placement Spots Included',
                        'Newsletter & Email Feature',
                        'Save 33% Annual Discount',
                    ],
                    'ngn' => 1200000,
                    'space_slugs' => array_keys($spaces),
                ],
            ];

            foreach ($bundles as $data) {
                $plan = AdvertisementPlan::query()->updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'billing_quantity' => $data['billing_quantity'],
                        'billing_period' => $data['billing_period'],
                        'impressions_included' => $data['impressions_included'],
                        'features' => $data['features'],
                        'is_active' => true,
                    ]
                );

                $spaceIds = collect($data['space_slugs'])
                    ->mapWithKeys(fn (string $slug): array => [$spaces[$slug]->id => ['quantity' => 1]])
                    ->all();
                $plan->spaces()->sync($spaceIds);
                $this->syncPrices($plan, [[$ngn, $data['ngn'], true]]);
            }
        });
    }

    /**
     * @return list<array{slug: string, name: string, description: string, format: string, dimensions: string, icon: string, sort_order: int, is_active: bool}>
     */
    private function spaces(): array
    {
        return [
            [
                'slug' => 'homepage-hero-banner',
                'name' => 'Homepage Hero Banner',
                'description' => 'Top-of-page visibility on the homepage for maximum exposure to incoming visitors.',
                'format' => 'Top Leaderboard',
                'dimensions' => '1200 x 300 px',
                'icon' => 'ri-home-4-line',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'catalog-listing-pages',
                'name' => 'Catalog & Listing Pages',
                'description' => 'Banner placement on property listing pages for users actively browsing properties.',
                'format' => 'Billboard Banner',
                'dimensions' => '970 x 250 px',
                'icon' => 'ri-building-line',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'property-details-page',
                'name' => 'Property Details Page',
                'description' => 'Sticky sidebar and calculator ad placement on property detail pages.',
                'format' => 'Sticky Sidebar & Calculator Ad',
                'dimensions' => '300 x 250 px',
                'icon' => 'ri-building-2-line',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'blog-article-sidebar',
                'name' => 'Blog & Article Sidebar',
                'description' => 'Sidebar and in-article banner placement alongside editorial content.',
                'format' => 'Skyscraper / In-Article',
                'dimensions' => '300 x 600 px',
                'icon' => 'ri-article-line',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'slug' => 'newsletter-email',
                'name' => 'Newsletter & Email',
                'description' => 'Sponsored placement in subscriber newsletters and email campaigns.',
                'format' => 'Sponsored Email Header',
                'dimensions' => '600 x 200 px',
                'icon' => 'ri-mail-open-line',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'slug' => 'partner-directory-listing',
                'name' => 'Partner Directory Listing',
                'description' => 'Featured directory profile for partner businesses.',
                'format' => 'Featured Directory Profile',
                'dimensions' => 'Logo + 50 Words',
                'icon' => 'ri-contacts-line',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];
    }

    /**
     * @param  list<array{0: Currency, 1: int, 2: bool}>  $prices
     */
    private function syncPrices(AdvertisementPlan $plan, array $prices): void
    {
        $plan->prices()->update(['is_default' => false]);

        foreach ($prices as [$currency, $amount, $isDefault]) {
            $plan->prices()->updateOrCreate(
                ['currency_id' => $currency->id],
                ['amount' => $amount, 'is_default' => $isDefault]
            );
        }
    }
}
