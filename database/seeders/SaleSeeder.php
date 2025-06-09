<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $sales = [
            [
                'name' => 'John Doe',
                'whatsapp' => '6281234567890',
                'email' => 'john@kiansantang.com',
                'description' => 'Specialist in iPhone and iPad products. Available 24/7 for your inquiries.',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'whatsapp' => '6289876543210',
                'email' => 'jane@kiansantang.com',
                'description' => 'Expert in MacBook and Apple Watch. Let me help you find the perfect device.',
                'is_active' => true,
            ],
            [
                'name' => 'Mike Johnson',
                'whatsapp' => '6287654321098',
                'email' => 'mike@kiansantang.com',
                'description' => 'Specialized in AirPods and audio accessories. Get the best sound experience.',
                'is_active' => true,
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create($sale);
        }
    }
} 