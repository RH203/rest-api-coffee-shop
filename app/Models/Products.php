<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    /** @use HasFactory<\Database\Factories\ProductsFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'name', 'description', 'image', 'price', 'stock', 'is_unlimited'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function varianProducts(): BelongsToMany
    {
        return $this->belongsToMany(VarianProduct::class, 'product_variants', 'product_id', 'varian_product_id')
            ->withPivot(['add_on_price']);
    }
}
