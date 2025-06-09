<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'iPhone',
                'description' => 'Apple iPhone smartphones and accessories',
            ],
            [
                'name' => 'iPad',
                'description' => 'Apple iPad tablets and accessories',
            ],
            [
                'name' => 'MacBook',
                'description' => 'Apple MacBook laptops and accessories',
            ],
            [
                'name' => 'Apple Watch',
                'description' => 'Apple Watch smartwatches and accessories',
            ],
            [
                'name' => 'AirPods',
                'description' => 'Apple AirPods and wireless audio accessories',
            ],
            [
                'name' => 'Aksesoris',
                'description' => 'Aksesoris resmi Apple dan kompatibel',
                'slug' => 'aksesoris'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
} 