<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

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

describe('category auth', function(){

    test('unauthenticated users are redirected from categories page', function(){
        get(route('dashboard.categories.index'))->assertRedirect(route('login'));
    });

    test('authenticated user can view categories list with inertia property', function(){
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);
        $category = Category::factory()->create();

        actingAs($user)->get(route('dashboard.categories.index'))
        ->assertStatus(200)
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('categories/index')
            ->has('categories.data', $category->id));
    });
});