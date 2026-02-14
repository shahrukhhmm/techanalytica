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
            'Analytics',
            'Marketing',
            'Development',
            'Design',
            'Productivity',
        ];

        foreach ($categories as $category) {
            Category::factory()->create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Description for ' . $category,
            ]);
        }
    }
}
