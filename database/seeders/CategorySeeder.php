<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [ 'name' => 'Personal' ],
            [ 'name' => 'Work' ],
            [ 'name' => 'Home' ],
            [ 'name' => 'Health and Fitness' ],
            [ 'name' => 'Study' ],
            [ 'name' => 'Social' ],
            [ 'name' => 'Errands' ],
            [ 'name' => 'Travel' ],
            [ 'name' => 'Financial' ],
            [ 'name' => 'Others' ],
        ]);
    }
}
