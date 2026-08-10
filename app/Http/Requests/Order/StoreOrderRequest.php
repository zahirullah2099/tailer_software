<?php

namespace App\Http\Requests\Order;

use App\Enums\DressType;
use App\Models\Measurement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreOrderRequest extends FormRequest
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
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'measurement_id' => ['required', 'integer', 'exists:measurements,id'],
            'dress_type' => ['required', Rule::enum(DressType::class)],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
            'total_amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['nullable', 'date', 'after_or_equal:order_date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Ensure the measurement actually belongs to the given customer.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->has('customer_id') || $validator->errors()->has('measurement_id')) {
                return;
            }

            $belongsToCustomer = Measurement::where('id', $this->input('measurement_id'))
                ->where('customer_id', $this->input('customer_id'))
                ->exists();

            if (! $belongsToCustomer) {
                $validator->errors()->add('measurement_id', 'This measurement does not belong to the selected customer.');
            }
        });
    }
}
