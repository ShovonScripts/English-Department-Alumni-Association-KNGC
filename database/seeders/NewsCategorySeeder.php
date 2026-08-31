<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Association News', 'description' => 'Official updates and announcements from the EDAA.', 'sort_order' => 1],
            ['name' => 'Alumni News', 'description' => 'News and achievements from our alumni community.', 'sort_order' => 2],
            ['name' => 'Department News', 'description' => 'Updates from the English Department.', 'sort_order' => 3],
            ['name' => 'Announcements', 'description' => 'Important announcements and notices.', 'sort_order' => 4],
            ['name' => 'Academic', 'description' => 'Academic programmes, lectures, and scholarly activities.', 'sort_order' => 5],
            ['name' => 'Events', 'description' => 'Event recaps and previews.', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            NewsCategory::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
