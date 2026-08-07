<?php

namespace App\Models;

use App\Enums\CollarType;
use App\Enums\CuffType;
use App\Enums\PocketType;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'taken_by',

        'chest',
        'shoulder',
        'sleeve',
        'neck',
        'shirt_length',

        'waist',
        'hip',
        'shalwar_length',
        'bottom_width',

        'collar',
        'cuff',
        'pocket_type',

        'fitting_notes',

        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'collar' => CollarType::class,
            'cuff' => CuffType::class,
            'pocket_type' => PocketType::class,
            'is_default' => 'boolean',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function takenBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'taken_by');
    } 

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
