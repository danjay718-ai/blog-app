<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Travel',
            'Food',
            'Lifestyle',
            'Technology',
            'Health',
            'Fitness',
            'Finance',
            'Education',
            'DIY',
            'Parenting',
            'Pets',
            'Business',
            'Marketing',
            'Self-Improvement',
            'Gaming',
            'Photography',
            'Art',
            'Music',
            'Books',
            'Fashion',
            'Productivity',
            'Motivation',
            'Science',
            'Environment',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
