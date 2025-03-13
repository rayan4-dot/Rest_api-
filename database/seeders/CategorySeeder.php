<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Insert categories with UUIDs
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Frontend Web Development',
            'parent_id' => null,
        ]);

        Category::create([
            'id' => Str::uuid(),
            'name' => 'Backend Web Development',
            'parent_id' => null,
        ]);


    }
}
