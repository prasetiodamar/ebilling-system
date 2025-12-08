<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'customer_number', 'full_name', 'package_type', 'monthly_fee',
        'phone', 'address', 'city', 'province', 'postal_code', 'status',
        'payment_status', 'last_payment_date', 'next_billing_date', 'balance',
        'router_mac_address', 'installation_address', 'notes',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
