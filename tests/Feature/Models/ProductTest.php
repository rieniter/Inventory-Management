<?php
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

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

describe('products auth', function(){

    test('unauthenticated users are redirected from products page', function(){
        get(route('dashboard.products.index'))->assertRedirect(route('login'));
    });

    test('authenticated user can view products list with inertia property', function(){
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);
        $product = Sku::factory()->create();

        actingAs($user)->get(route('dashboard.products.index'))
        ->assertStatus(200)
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('products/index')
            ->has('products.data', $product->id));
    });
});