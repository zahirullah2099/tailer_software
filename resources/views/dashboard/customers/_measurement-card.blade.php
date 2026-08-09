@if ($measurement)

    <div class="border border-gray-100 rounded-lg p-4">

        <div class="flex items-center justify-between mb-3">
            <span class="text-sm text-gray-400">
                Taken on {{ $measurement->created_at->format('d M, Y') }}
            </span>

            @if ($measurement->is_default)
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Default</span>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
            <div><span class="text-gray-400">Chest:</span> {{ $measurement->chest ?? '-' }}</div>
            <div><span class="text-gray-400">Shoulder:</span> {{ $measurement->shoulder ?? '-' }}</div>
            <div><span class="text-gray-400">Sleeve:</span> {{ $measurement->sleeve ?? '-' }}</div>
            <div><span class="text-gray-400">Neck:</span> {{ $measurement->neck ?? '-' }}</div>
            <div><span class="text-gray-400">Shirt Length:</span> {{ $measurement->shirt_length ?? '-' }}</div>
            <div><span class="text-gray-400">Waist:</span> {{ $measurement->waist ?? '-' }}</div>
            <div><span class="text-gray-400">Hip:</span> {{ $measurement->hip ?? '-' }}</div>
            <div><span class="text-gray-400">Shalwar Length:</span> {{ $measurement->shalwar_length ?? '-' }}</div>
            <div><span class="text-gray-400">Bottom Width:</span> {{ $measurement->bottom_width ?? '-' }}</div>
            <div><span class="text-gray-400">Collar:</span> {{ $measurement->collar?->value ?? '-' }}</div>
            <div><span class="text-gray-400">Cuff:</span> {{ $measurement->cuff?->value ?? '-' }}</div>
            <div><span class="text-gray-400">Pocket:</span> {{ $measurement->pocket_type?->value ?? '-' }}</div>
        </div>

        @if ($measurement->fitting_notes)
            <p class="text-sm text-gray-500 mt-3">
                <span class="text-gray-400">Notes:</span> {{ $measurement->fitting_notes }}
            </p>
        @endif

    </div>

@else
    <p class="text-gray-400 text-sm">No measurements recorded yet.</p>
@endif
