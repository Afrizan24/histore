<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'description' => 'iPhone 15 Pro Max dengan chip A17 Pro, kamera 48MP, dan Dynamic Island.',
                'price' => 19999000,
                'stock' => 10,
                'category' => 'iPhone',
                'warna' => 'Natural Titanium',
                'kondisi' => 'baru',
                'storage' => '256GB',
            ],
            [
                'name' => 'iPhone 15',
                'slug' => 'iphone-15',
                'description' => 'iPhone 15 dengan chip A16 Bionic, kamera 48MP, dan Dynamic Island.',
                'price' => 14999000,
                'stock' => 15,
                'category' => 'iPhone',
                'warna' => 'Black',
                'kondisi' => 'baru',
                'storage' => '128GB',
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'slug' => 'ipad-pro-12-9',
                'description' => 'iPad Pro 12.9" dengan chip M2, Liquid Retina XDR display, dan Thunderbolt.',
                'price' => 24999000,
                'stock' => 8,
                'category' => 'iPad',
                'warna' => 'Space Gray',
                'kondisi' => 'baru',
                'storage' => '256GB',
            ],
            [
                'name' => 'MacBook Pro 16"',
                'slug' => 'macbook-pro-16',
                'description' => 'MacBook Pro 16" dengan chip M3 Pro, Liquid Retina XDR display, dan 18GB RAM.',
                'price' => 39999000,
                'stock' => 5,
                'category' => 'MacBook',
                'warna' => 'Space Gray',
                'kondisi' => 'baru',
                'storage' => '512GB',
            ],
            [
                'name' => 'MacBook Air 15"',
                'slug' => 'macbook-air-15',
                'description' => 'Thin and light laptop with M2 chip, perfect for everyday use.',
                'price' => 19999000,
                'stock' => 12,
                'category' => 'MacBook',
                'warna' => 'Midnight',
                'kondisi' => 'baru',
                'storage' => '256GB',
            ],
            [
                'name' => 'Apple Watch Series 9',
                'slug' => 'apple-watch-series-9',
                'description' => 'Apple Watch Series 9 dengan chip S9, Always-On display, dan fitur kesehatan canggih.',
                'price' => 7999000,
                'stock' => 12,
                'category' => 'Apple Watch',
                'warna' => 'Midnight',
                'kondisi' => 'baru',
                'storage' => '45mm',
            ],
            [
                'name' => 'AirPods Pro 2',
                'slug' => 'airpods-pro-2',
                'description' => 'AirPods Pro 2 dengan Active Noise Cancellation, Transparency mode, dan MagSafe Charging Case.',
                'price' => 4999000,
                'stock' => 20,
                'category' => 'AirPods',
                'warna' => 'White',
                'kondisi' => 'baru',
                'storage' => null,
            ],
            [
                'name' => 'MagSafe Charger',
                'slug' => 'magsafe-charger',
                'description' => 'MagSafe Charger untuk iPhone 12 ke atas dengan pengisian daya nirkabel 15W.',
                'price' => 899000,
                'stock' => 25,
                'category' => 'Aksesoris',
                'warna' => 'White',
                'kondisi' => 'baru',
                'storage' => null,
            ],
            [
                'name' => 'Apple Pencil 2',
                'slug' => 'apple-pencil-2',
                'description' => 'Apple Pencil 2 untuk iPad Pro dan iPad Air dengan pengisian daya nirkabel.',
                'price' => 2499000,
                'stock' => 15,
                'category' => 'Aksesoris',
                'warna' => 'White',
                'kondisi' => 'baru',
                'storage' => null,
            ],
            [
                'name' => 'iPhone 15 Pro Case',
                'slug' => 'iphone-15-pro-case',
                'description' => 'Case resmi Apple untuk iPhone 15 Pro dengan material premium dan perlindungan maksimal.',
                'price' => 899000,
                'stock' => 30,
                'category' => 'Aksesoris',
                'warna' => 'Black',
                'kondisi' => 'baru',
                'storage' => null,
            ],
            [
                'name' => 'AirTag',
                'slug' => 'airtag',
                'description' => 'AirTag untuk melacak barang berharga Anda dengan teknologi Find My.',
                'price' => 799000,
                'stock' => 40,
                'category' => 'Aksesoris',
                'warna' => 'White',
                'kondisi' => 'baru',
                'storage' => null,
            ],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            
            Product::create([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category_id' => $category->id,
                'warna' => $product['warna'] ?? null,
                'kondisi' => $product['kondisi'] ?? 'baru',
                'storage' => $product['storage'] ?? null,
            ]);
        }
    }
} 