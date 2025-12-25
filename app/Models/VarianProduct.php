<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VarianProduct extends Model
{
    /** @use HasFactory<\Database\Factories\VarianProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, 'product_variants', 'varian_product_id', 'product_id')
            ->withPivot(['add_on_price']);
    }
}
