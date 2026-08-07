<?php

namespace App\Models;

use App\Enums\DressType;
use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Measurement;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'measurement_id',
        'created_by',

        'dress_type',
        'quantity',

        'total_amount',

        'order_date',
        'delivery_date',
        'delivered_at',

        'status',

        'notes',
    ];

    protected function casts(): array
    {
        return [
            'dress_type'   => DressType::class,
            'status'       => OrderStatus::class,

            'order_date'   => 'date',
            'delivery_date' => 'date',
            'delivered_at' => 'datetime',

            'total_amount' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    protected function orderNumber(): Attribute
    {
        return Attribute::make(
            get: fn() => 'ORD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
        );
    }
}
