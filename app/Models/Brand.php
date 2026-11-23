<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'country',
        'description',
    ];

    /**
     * Relación: una marca tiene muchos autos.
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Scope para obtener marcas ordenadas alfabéticamente.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }
}
