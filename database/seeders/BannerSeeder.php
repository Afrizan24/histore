<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'iPhone 15 Pro Max Launch',
                'description' => 'Discover the latest iPhone with revolutionary features and stunning design. Experience the future of mobile technology.',
                'image' => null,
                'button_text' => 'Shop Now',
                'button_url' => '/products/category/iphone',
                'order' => 1,
                'is_active' => false,
            ],
            [
                'title' => 'MacBook Air M2',
                'description' => 'Powerful performance meets incredible battery life. The new MacBook Air with M2 chip is here.',
                'image' => null,
                'button_text' => 'Learn More',
                'button_url' => '/products/category/macbook',
                'order' => 2,
                'is_active' => false,
            ],
            [
                'title' => 'iPad Pro Collection',
                'description' => 'Transform your creativity with the most advanced iPad ever. Pro performance for everyone.',
                'image' => null,
                'button_text' => 'Explore',
                'button_url' => '/products/category/ipad',
                'order' => 3,
                'is_active' => false,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
