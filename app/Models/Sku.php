<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    /** @use HasFactory<\Database\Factories\SkuFactory> */
    use HasFactory;

    protected $fillable = ['products_id', 'code', 'unit_cost', 'stock'];
    
    // Relationship: Sku belong to Product:
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
