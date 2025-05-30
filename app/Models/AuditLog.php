<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'action',
        'details'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}