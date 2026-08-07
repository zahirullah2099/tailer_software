<div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500 text-sm">
                {{ $title }}
            </p>

            <h2 class="text-3xl font-bold mt-2">
                {{ $value }}
            </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-{{ $color }}-100 flex items-center justify-center">

            <i class="fa-solid fa-{{ $icon }} text-{{ $color }}-600 text-2xl"></i>

        </div>

    </div>

</div>