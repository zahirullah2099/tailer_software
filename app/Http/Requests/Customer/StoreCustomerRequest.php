<?php

namespace App\Http\Requests\Customer;

use App\Enums\CollarType;
use App\Enums\CuffType;
use App\Enums\PocketType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Customer info
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'alternate_phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],

            // Measurements (all optional)
            'chest' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'shoulder' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'sleeve' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'neck' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'shirt_length' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'waist' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'hip' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'shalwar_length' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'bottom_width' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'collar' => ['nullable', Rule::enum(CollarType::class)],
            'cuff' => ['nullable', Rule::enum(CuffType::class)],
            'pocket_type' => ['nullable', Rule::enum(PocketType::class)],
            'fitting_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
