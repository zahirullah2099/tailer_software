@props(['title', 'value', 'icon', 'color' => 'blue'])

<div class="relative overflow-hidden rounded-2xl border border-gray-100 bg-gradient-to-br from-{{ $color }}-50 to-white p-6 shadow-sm transition-shadow hover:shadow-md">

    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-{{ $color }}-100/60"></div>

    <div class="relative flex items-center justify-between">

        <div>
            <p class="text-sm font-medium text-gray-500">
                {{ $title }}
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                {{ $value }}
            </h2>
        </div>

        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 shadow-lg shadow-{{ $color }}-500/30">
            <i class="fa-solid fa-{{ $icon }} text-xl text-white"></i>
        </div>

    </div>

</div>
