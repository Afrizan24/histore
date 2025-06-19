<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            SaleSeeder::class,
            BannerSeeder::class,
        ]);

        // Create categories
        $categories = [
            ['name' => 'iPhone', 'slug' => 'iphone'],
            ['name' => 'iPad', 'slug' => 'ipad'],
            ['name' => 'MacBook', 'slug' => 'macbook'],
            ['name' => 'iWatch', 'slug' => 'iwatch'],
            ['name' => 'AirPods', 'slug' => 'airphone'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create products with more variations
        $products = [
            // iPhone Products
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'category_id' => Category::where('slug', 'iphone')->first()->id,
                'price' => 19999000,
                'warna' => 'Natural Titanium',
                'kondisi' => 'New',
                'storage' => '256GB',
                'description' => 'iPhone 15 Pro Max dengan chip A17 Pro, kamera 48MP, dan desain titanium.',
                'image' => 'products/iphone-15-pro-max.jpg'
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max-512',
                'category_id' => Category::where('slug', 'iphone')->first()->id,
                'price' => 22999000,
                'warna' => 'Natural Titanium',
                'kondisi' => 'New',
                'storage' => '512GB',
                'description' => 'iPhone 15 Pro Max dengan chip A17 Pro, kamera 48MP, dan desain titanium.',
                'image' => 'products/iphone-15-pro-max.jpg'
            ],
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'category_id' => Category::where('slug', 'iphone')->first()->id,
                'price' => 17999000,
                'warna' => 'Blue Titanium',
                'kondisi' => 'New',
                'storage' => '256GB',
                'description' => 'iPhone 15 Pro dengan chip A17 Pro dan desain titanium.',
                'image' => 'products/iphone-15-pro.jpg'
            ],
            [
                'name' => 'iPhone 14 Pro Max',
                'slug' => 'iphone-14-pro-max',
                'category_id' => Category::where('slug', 'iphone')->first()->id,
                'price' => 15999000,
                'warna' => 'Deep Purple',
                'kondisi' => 'Second',
                'storage' => '128GB',
                'description' => 'iPhone 14 Pro Max dengan Dynamic Island dan kamera 48MP.',
                'image' => 'products/iphone-14-pro-max.jpg'
            ],
            [
                'name' => 'iPhone 14',
                'slug' => 'iphone-14',
                'category_id' => Category::where('slug', 'iphone')->first()->id,
                'price' => 12999000,
                'warna' => 'Midnight',
                'kondisi' => 'Second',
                'storage' => '256GB',
                'description' => 'iPhone 14 dengan chip A15 Bionic dan kamera ganda.',
                'image' => 'products/iphone-14.jpg'
            ],

            // iPad Products
            [
                'name' => 'iPad Pro 12.9" M2',
                'slug' => 'ipad-pro-12-9-m2',
                'category_id' => Category::where('slug', 'ipad')->first()->id,
                'price' => 19999000,
                'warna' => 'Space Gray',
                'kondisi' => 'New',
                'storage' => '256GB',
                'description' => 'iPad Pro 12.9" dengan chip M2 dan display Liquid Retina XDR.',
                'image' => 'products/ipad-pro.jpg'
            ],
            [
                'name' => 'iPad Pro 12.9" M2',
                'slug' => 'ipad-pro-12-9-m2-512',
                'category_id' => Category::where('slug', 'ipad')->first()->id,
                'price' => 22999000,
                'warna' => 'Space Gray',
                'kondisi' => 'New',
                'storage' => '512GB',
                'description' => 'iPad Pro 12.9" dengan chip M2 dan display Liquid Retina XDR.',
                'image' => 'products/ipad-pro.jpg'
            ],
            [
                'name' => 'iPad Air',
                'slug' => 'ipad-air',
                'category_id' => Category::where('slug', 'ipad')->first()->id,
                'price' => 9999000,
                'warna' => 'Starlight',
                'kondisi' => 'Second',
                'storage' => '256GB',
                'description' => 'iPad Air dengan chip M1 dan desain tipis.',
                'image' => 'products/ipad-air.jpg'
            ],
            [
                'name' => 'iPad Mini',
                'slug' => 'ipad-mini',
                'category_id' => Category::where('slug', 'ipad')->first()->id,
                'price' => 7999000,
                'warna' => 'Pink',
                'kondisi' => 'Second',
                'storage' => '128GB',
                'description' => 'iPad Mini dengan chip A15 Bionic dan desain compact.',
                'image' => 'products/ipad-mini.jpg'
            ],

            // MacBook Products
            [
                'name' => 'MacBook Pro 16" M3 Pro',
                'slug' => 'macbook-pro-16-m3-pro',
                'category_id' => Category::where('slug', 'macbook')->first()->id,
                'price' => 32999000,
                'warna' => 'Space Gray',
                'kondisi' => 'New',
                'storage' => '512GB',
                'description' => 'MacBook Pro 16" dengan chip M3 Pro dan display Liquid Retina XDR.',
                'image' => 'products/macbook-pro.jpg'
            ],
            [
                'name' => 'MacBook Pro 16" M3 Pro',
                'slug' => 'macbook-pro-16-m3-pro-1tb',
                'category_id' => Category::where('slug', 'macbook')->first()->id,
                'price' => 37999000,
                'warna' => 'Space Gray',
                'kondisi' => 'New',
                'storage' => '1TB',
                'description' => 'MacBook Pro 16" dengan chip M3 Pro dan display Liquid Retina XDR.',
                'image' => 'products/macbook-pro.jpg'
            ],
            [
                'name' => 'MacBook Air M2',
                'slug' => 'macbook-air-m2',
                'category_id' => Category::where('slug', 'macbook')->first()->id,
                'price' => 15999000,
                'warna' => 'Midnight',
                'kondisi' => 'Second',
                'storage' => '256GB',
                'description' => 'MacBook Air dengan chip M2 dan desain tipis.',
                'image' => 'products/macbook-air.jpg'
            ],

            // iWatch Products
            [
                'name' => 'Apple Watch Series 9',
                'slug' => 'apple-watch-series-9',
                'category_id' => Category::where('slug', 'iwatch')->first()->id,
                'price' => 7999000,
                'warna' => 'Midnight',
                'kondisi' => 'New',
                'storage' => '45mm',
                'description' => 'Apple Watch Series 9 dengan chip S9 dan fitur Double Tap.',
                'image' => 'products/apple-watch.jpg'
            ],
            [
                'name' => 'Apple Watch Series 9',
                'slug' => 'apple-watch-series-9-41',
                'category_id' => Category::where('slug', 'iwatch')->first()->id,
                'price' => 6999000,
                'warna' => 'Starlight',
                'kondisi' => 'New',
                'storage' => '41mm',
                'description' => 'Apple Watch Series 9 dengan chip S9 dan fitur Double Tap.',
                'image' => 'products/apple-watch.jpg'
            ],
            [
                'name' => 'Apple Watch Ultra 2',
                'slug' => 'apple-watch-ultra-2',
                'category_id' => Category::where('slug', 'iwatch')->first()->id,
                'price' => 12999000,
                'warna' => 'Titanium',
                'kondisi' => 'Second',
                'storage' => '49mm',
                'description' => 'Apple Watch Ultra 2 dengan chip S9 dan desain titanium.',
                'image' => 'products/apple-watch-ultra.jpg'
            ],

            // AirPods Products
            [
                'name' => 'AirPods Pro 2',
                'slug' => 'airpods-pro-2',
                'category_id' => Category::where('slug', 'airphone')->first()->id,
                'price' => 3999000,
                'warna' => 'White',
                'kondisi' => 'New',
                'storage' => 'USB-C',
                'description' => 'AirPods Pro 2 dengan chip H2 dan fitur Adaptive Audio.',
                'image' => 'products/airpods-pro.jpg'
            ],
            [
                'name' => 'AirPods 3',
                'slug' => 'airpods-3',
                'category_id' => Category::where('slug', 'airphone')->first()->id,
                'price' => 2999000,
                'warna' => 'White',
                'kondisi' => 'Second',
                'storage' => 'Lightning',
                'description' => 'AirPods 3 dengan desain baru dan fitur Spatial Audio.',
                'image' => 'products/airpods.jpg'
            ],

            // Aksesoris Products
            [
                'name' => 'MagSafe Charger',
                'slug' => 'magsafe-charger',
                'category_id' => Category::where('slug', 'aksesoris')->first()->id,
                'price' => 499000,
                'warna' => 'White',
                'kondisi' => 'New',
                'storage' => 'Standard',
                'description' => 'MagSafe Charger untuk iPhone dan AirPods.',
                'image' => 'products/magsafe.jpg'
            ],
            [
                'name' => 'Apple Watch Band',
                'slug' => 'apple-watch-band',
                'category_id' => Category::where('slug', 'aksesoris')->first()->id,
                'price' => 799000,
                'warna' => 'Blue',
                'kondisi' => 'New',
                'storage' => '45mm',
                'description' => 'Sport Band untuk Apple Watch.',
                'image' => 'products/watch-band.jpg'
            ],
            [
                'name' => 'iPhone Case',
                'slug' => 'iphone-case',
                'category_id' => Category::where('slug', 'aksesoris')->first()->id,
                'price' => 599000,
                'warna' => 'Black',
                'kondisi' => 'Second',
                'storage' => 'iPhone 15 Pro',
                'description' => 'Silicone Case untuk iPhone 15 Pro.',
                'image' => 'products/iphone-case.jpg'
            ]
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
