<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'model',
        'year',
        'sale_price',
        'rental_price',
        'image',
        'description',
        'fuel_type',
        'transmission',
        'horsepower',
        'top_speed',
        'is_available',
    ];

    protected $casts = [
        'sale_price' => 'decimal:2',
        'rental_price' => 'decimal:2',
        'is_available' => 'boolean',
        'year' => 'integer',
        'horsepower' => 'integer',
        'top_speed' => 'integer',
    ];

    /**
     * Relación: un auto pertenece a una marca.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Formatea el precio de venta en formato moneda MXN.
     */
    public function getFormattedSalePriceAttribute(): string
    {
        return '$' . number_format((float) $this->sale_price, 2, '.', ',') . ' MXN';
    }

    /**
     * Formatea el precio de alquiler por día.
     */
    public function getFormattedRentalPriceAttribute(): string
    {
        return '$' . number_format((float) $this->rental_price, 2, '.', ',') . ' MXN/día';
    }
}
