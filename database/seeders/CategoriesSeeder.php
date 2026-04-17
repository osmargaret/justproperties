<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::createMany([
            [
                'name' => 'Landed Properties',
                'requirements' => json_encode([
                    'type' => [
                        'Foundation Level',
                        'Walls Level',
                        'Roofing Level',
                        'Finishing Stage',
                        'Semi-Detached',
                        'Terrace',
                        'Bungalow'
                    ],
                    'area' => 'input',
                    'area_unit' => [
                        'sqm' => 'sqm',
                        'sqft' => 'sqft',
                        'acres' => 'acres',
                        'hectares' => 'hectares'
                    ],
                ]),
            ],
            [
                'name' => 'Completed Properties',
                'requirements' => json_encode([
                    'type' => [
                        'Detached Duplex',
                        'Semi-Detached',
                        'Terrace',
                        'Bungalow',
                        'Semi-Detached',
                        'Terrace',
                        'Bungalow',
                        'Mansion'
                    ],
                ]),
                'bedrooms' => [],
                'features' => [
                    'swimming pool',
                    'gym',
                    'parking_space',
                    'furnished',
                    '24/7 security'
                ],
            ],
            
        ]);
    }
}
