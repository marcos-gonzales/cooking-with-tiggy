<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'marcos@example.org',
            'name' => 'Marcos Gonzales',
            'password' => bcrypt('password')
        ]);

        User::factory(15)->create();
        Category::create(['name' => 'Italian']);
        Category::create(['name' => 'American']);
        Category::create(['name' => 'Mexican']);
        Category::create(['name' => 'Peruvian']);
        Category::create(['name' => 'Thai']);
        Category::create(['name' => 'Chinese']);
        Category::create(['name' => 'BBQ']);
        Category::create(['name' => 'Indian']);

        $this->call(RecipeSeeder::class);
        
    }
}
