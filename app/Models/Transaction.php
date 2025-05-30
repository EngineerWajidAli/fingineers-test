<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'transaction_type',
        'sale_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}