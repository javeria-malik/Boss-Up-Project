<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $male = Category::create(['name' => 'Male']);
        Category::create(['name' => 'Shirts', 'parent_id' => $male->id]);
        Category::create(['name' => 'Pants', 'parent_id' => $male->id]);
        Category::create(['name' => 'Shoes', 'parent_id' => $male->id]);

        $female = Category::create(['name' => 'Female']);
        Category::create(['name' => 'Dresses', 'parent_id' => $female->id]);
        Category::create(['name' => 'Tops', 'parent_id' => $female->id]);
        Category::create(['name' => 'Heels', 'parent_id' => $female->id]);

        $children = Category::create(['name' => 'Children']);
        Category::create(['name' => 'T-Shirts', 'parent_id' => $children->id]);
        Category::create(['name' => 'Shorts', 'parent_id' => $children->id]);
        Category::create(['name' => 'Sandals', 'parent_id' => $children->id]);
    }
}
