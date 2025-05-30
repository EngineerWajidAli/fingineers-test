<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'days',
        'discounts',
        'min_quantity',
        'quantity_discount',
        'precedence'
    ];

    protected $casts = [
        'days' => 'array',
        'discounts' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}