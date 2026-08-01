<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    /** @use HasFactory<\Database\Factories\SkuFactory> */
    use HasFactory;

    protected $fillable = ['product_id', 'code', 'unit_cost', 'stock'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
