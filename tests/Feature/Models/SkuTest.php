<?php
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

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
