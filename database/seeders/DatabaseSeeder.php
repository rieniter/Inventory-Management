<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crete default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'System Admin', 
            'password' => Hash::make('password'),
            'email_verified_at' => now()]
        );
        // Random chain data
        Category::factory(10)->create()->each(function ($category) {
            Product::factory(50)
                ->for($category)
                ->has(Sku::factory()->count(rand(1,5)))
                ->create();
        });
    }
}
