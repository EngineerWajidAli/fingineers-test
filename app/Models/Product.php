<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description'
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class);
    }
}