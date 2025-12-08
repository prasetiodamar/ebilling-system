<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'payment_number',
        'payment_method',
        'payment_gateway',
        'gateway_reference_id',
        'amount',
        'status',
        'payment_date',
        'description',
        'notes',
        'gateway_response',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'gateway_response' => 'json',
    ];

    /**
     * Relationships
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeByGateway($query, string $gateway)
    {
        return $query->where('payment_gateway', $gateway);
    }

    public function scopeByMethod($query, string $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Accessors & Mutators
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Methods
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'payment_date' => now(),
        ]);

        // Update invoice
        if ($this->invoice) {
            $this->invoice->markAsPaid($this->amount);
        }
    }

    public function markAsFailed(array $reason = []): void
    {
        $this->update([
            'status' => 'failed',
            'gateway_response' => $reason,
        ]);
    }

    public function refund(): void
    {
        $this->update(['status' => 'refunded']);

        // Revert invoice payment
        if ($this->invoice) {
            $this->invoice->update([
                'paid_amount' => max(0, $this->invoice->paid_amount - $this->amount),
                'status' => 'unpaid',
            ]);
        }
    }
}
