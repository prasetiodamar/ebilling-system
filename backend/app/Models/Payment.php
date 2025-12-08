<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_id', 'customer_id', 'payment_number', 'payment_method',
        'payment_gateway', 'gateway_reference_id', 'amount', 'status',
        'payment_date', 'description', 'notes', 'gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'gateway_response' => 'json',
    ];

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
