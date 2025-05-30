<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'rule_type',
        'min_quantity',
        'discount_amount',
        'markup_amount',
        'valid_from',
        'valid_to',
        'precedence'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}