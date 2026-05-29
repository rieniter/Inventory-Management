<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id'];

    // Relationship: Product have 1 Sku:
    public function sku()
    {
        return $this->hasOne(Sku::class);
    }
}
