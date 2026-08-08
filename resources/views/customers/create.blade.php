@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add Customer</h1>

        <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i> Back to Customers
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6" x-data="{ tab: 'customer' }">

        <div id="alertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-6">
            <button type="button"
                    @click="tab = 'customer'"
                    :class="tab === 'customer' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'"
                    class="px-5 py-3 border-b-2 font-medium">
                <i class="fa-solid fa-user"></i> Customer Info
            </button>

            <button type="button"
                    @click="tab = 'measurement'"
                    :class="tab === 'measurement' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'"
                    class="px-5 py-3 border-b-2 font-medium">
                <i class="fa-solid fa-ruler"></i> Measurements (Optional)
            </button>
        </div>

        <form id="customerForm">
            @csrf

            <!-- Customer Info Tab -->
            <div x-show="tab === 'customer'" class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="name"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <input type="text" name="phone"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alternate Phone</label>
                    <input type="text" name="alternate_phone"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="alternate_phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="address"></p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="notes"></p>
                </div>

            </div>

            <!-- Measurement Tab -->
            <div x-show="tab === 'measurement'" x-cloak>

                <p class="text-sm text-gray-500 mb-4">
                    Leave blank if measurements will be taken later.
                </p>

                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Shirt</h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-6">

                    @foreach (['chest' => 'Chest', 'shoulder' => 'Shoulder', 'sleeve' => 'Sleeve', 'neck' => 'Neck', 'shirt_length' => 'Shirt Length'] as $field => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                            <input type="number" step="0.01" name="{{ $field }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-red-600 text-sm mt-1 field-error" data-field="{{ $field }}"></p>
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Collar</label>
                        <select name="collar" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select --</option>
                            @foreach (\App\Enums\CollarType::cases() as $case)
                                <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm mt-1 field-error" data-field="collar"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cuff</label>
                        <select name="cuff" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select --</option>
                            @foreach (\App\Enums\CuffType::cases() as $case)
                                <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm mt-1 field-error" data-field="cuff"></p>
                    </div>

                </div>

                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Shalwar</h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-6">

                    @foreach (['waist' => 'Waist', 'hip' => 'Hip', 'shalwar_length' => 'Shalwar Length', 'bottom_width' => 'Bottom Width'] as $field => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                            <input type="number" step="0.01" name="{{ $field }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-red-600 text-sm mt-1 field-error" data-field="{{ $field }}"></p>
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pocket Type</label>
                        <select name="pocket_type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select --</option>
                            @foreach (\App\Enums\PocketType::cases() as $case)
                                <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm mt-1 field-error" data-field="pocket_type"></p>
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fitting Notes</label>
                    <textarea name="fitting_notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="fitting_notes"></p>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('customers.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit" id="submitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Customer
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#customerForm').on('submit', function (e) {
            e.preventDefault();

            $('.field-error').text('');
            $('#alertBox').addClass('hidden').text('');

            const $btn = $('#submitBtn');
            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: '{{ route("customers.store") }}',
                type: 'POST',
                data: $('#customerForm').serialize(),
                success: function (response) {
                    window.location.href = response.redirect_url;
                },
                error: function (xhr) {
                    $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Customer');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        $.each(errors, function (field, messages) {
                            $('.field-error[data-field="' + field + '"]').text(messages[0]);
                        });

                        $('#alertBox')
                            .removeClass('hidden')
                            .addClass('bg-red-50 text-red-700 border border-red-200')
                            .text('Please fix the errors below.');
                    } else {
                        $('#alertBox')
                            .removeClass('hidden')
                            .addClass('bg-red-50 text-red-700 border border-red-200')
                            .text('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
</script>
@endpush
