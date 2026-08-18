@props(['title', 'value', 'icon', 'color' => 'blue'])

<div class="relative overflow-hidden rounded-2xl border border-{{ $color }}-200 bg-{{ $color }}-200 p-6 shadow-sm transition-shadow hover:shadow-md mb-4">

    {{-- <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-{{ $color }}-200/50"></div> --}}

    <div class="relative flex items-center justify-between">

        <div>
            <p class="text-sm font-medium text-{{ $color }}-700">
                {{ $title }}
            </p>

            <h2 class="mt-2 text-3xl font-bold text-{{ $color }}-900">
                {{ $value }}
            </h2>
        </div>

        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-{{ $color }}-500 shadow-lg shadow-{{ $color }}-500/40">
            <i class="fa-solid fa-{{ $icon }} text-xl text-white"></i>
        </div>

    </div>

</div>
