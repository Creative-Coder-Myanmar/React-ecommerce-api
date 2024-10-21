<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => 'adminpassword',
            'role_id' => Role::factory()->create(['name' => 'admin'])->id
        ]);

        Category::factory()->create([
            'name' => "Beauty"
        ]);
        Category::factory()->create([
            'name' => "Clothes"
        ]);
        Category::factory()->create([
            'name' => "Electronic"
        ]);
        Category::factory()->create([
            'name' => "Food"
        ]);
        Category::factory()->create([
            'name' => "Daily Life Good"
        ]);
        Product::factory(10)
            ->hasImages(3)
            ->create();


        Order::factory(10)
            ->hasAttached(
                Product::factory()->count(3),  // Creating 3 products per order
                ['quantity' => fake()->numberBetween(1, 5)]     // Set quantity dynamically in the pivot table
            )
            ->create();
    }
}
