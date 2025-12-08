<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'customer_number',
        'full_name',
        'package_type',
        'monthly_fee',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'status',
        'payment_status',
        'last_payment_date',
        'next_billing_date',
        'balance',
        'router_mac_address',
        'installation_address',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'balance' => 'decimal:2',
        'last_payment_date' => 'datetime',
        'next_billing_date' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('payment_status', 'overdue');
    }

    /**
     * Accessors & Mutators
     */
    public function getOutstandingBalanceAttribute(): float
    {
        return $this->invoices()
            ->whereNotIn('status', ['paid', 'cancelled'])
            ->sum('total_amount') - $this->balance;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->payment_status === 'overdue';
    }
}
