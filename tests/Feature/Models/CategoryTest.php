<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

uses(RefreshDatabase::class);
describe('category created and relationship', function(){

    test('category can be created via factory', function () {
        $category = Category::factory()->create([
            'name' => 'TestName',
        ]);
        assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'TestName',
        ]);
    });

    test('category has many products', function () {
        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create([
            'category_id' => $category->id,
        ]);
        assertCount(3, $category->products);
        assertEquals($products->first()->id, $category->products->first()->id);
    });
});
