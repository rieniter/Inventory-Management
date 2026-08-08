<?php
use App\Models\Product;
use App\Models\Sku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\actingAs;
use Inertia\Testing\AssertableInertia;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

describe('Sku created and relationship', function(){
    test('sku can be create via factory', function () {
        $sku = Sku::factory()->create([
            'code' => 'ABC-12345',
            'unit_cost' => 1111,
            'stock' => 111,
        ]);

        assertDatabaseHas('skus', [
            'id' => $sku->id,
            'product_id' => $sku->product_id,
            'code' => 'ABC-12345',
            'unit_cost' => 1111,
            'stock' => 111,
        ]);
    });

    test('sku belongs to a product', function(){
        $product = Product::factory()->create(['name' => 'Android Phone']);
        $sku = Sku::factory()->for($product)->create();

        assertInstanceOf(Product::class, $sku->product);
        assertEquals('Android Phone', $sku->product->name);
    });
});
describe('skus auth', function(){

    test('unauthenticated users are redirected from skus page', function(){
        get(route('dashboard.skus.index'))->assertRedirect(route('login'));
    });

    test('authenticated user can view skus list with inertia property', function(){
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);
        $sku = Sku::factory()->create();

        actingAs($user)->get(route('dashboard.skus.index'))
        ->assertStatus(200)
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('skus/index')
            ->has('skus.data', $sku->id));
    });
});