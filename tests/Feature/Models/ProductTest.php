<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

describe('product created and relationship', function(){

    test('product can be create via factory', function(){
        $category = Category::factory()->create(['name' => 'Phone']);
        $product = Product::factory()->create([
            'name' => 'Android',
            'description' => 'Pixel, Google',
            'category_id' => $category->id
        ]);

        assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Android',
            'description' => 'Pixel, Google',
            'category_id' => $category->id
        ]);
    });

    test('product belongs to a category', function () {
        $category = Category::factory()->create(['name' => 'Laptops']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        assertInstanceOf(Category::class, $product->category);
        assertEquals('Laptops', $product->category->name);
    });

    test('product have many Sku', function(){
        $product = Product::factory()->create();
        $skus = Sku::factory(4)->create(['product_id' => $product->id]);

        assertInstanceOf(Collection::class, $product->skus);
        assertCount(4, $product->skus);
        assertInstanceOf(Sku::class, $product->skus->first());
        assertTrue($product->skus->first()->is($skus->first()));
    });
});

