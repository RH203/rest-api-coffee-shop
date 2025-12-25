<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tables extends Model
{
    /** @use HasFactory<\Database\Factories\TablesFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'is_used'];

    public function order(): HasMany
    {
        return $this->hasMany(Orders::class);
    }
}
