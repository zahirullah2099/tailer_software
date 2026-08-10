<?php

namespace App\Http\Requests\Order;

use App\Enums\DressType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'dress_type' => ['required', Rule::enum(DressType::class)],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
            'total_amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['nullable', 'date', 'after_or_equal:order_date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
