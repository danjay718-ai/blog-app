<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'Latest trends and updates in technology.',
                // 'status' => 'active'
            ],
            [
                'name' => 'Health',
                'description' => 'Health tips, news, and lifestyle advice.',
                // 'status' => 'active'
            ],
            [
                'name' => 'Travel',
                'description' => 'Travel destinations, guides, and tips.',
                // 'status' => 'inactive'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                // 'status' => $category['status'],
            ]);
        }
    }
}
