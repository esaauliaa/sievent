@props([
    'title',
    'value',
    'subtitle',
    'icon',
    'color' => '#0056B3'
])

<div class="bg-white rounded-3xl p-6 border border-blue-100 shadow-sm hover:shadow-lg transition">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-bold text-gray-500 mb-2">
                {{ $title }}
            </p>

            <h3 class="text-4xl font-extrabold text-[#131D4F] leading-none">
                {{ $value }}
            </h3>

            <p class="text-sm text-gray-500 mt-3">
                {{ $subtitle }}
            </p>
        </div>

        <div
            class="w-14 h-14 rounded-2xl flex items-center justify-center text-white"
            style="background-color: {{ $color }}"
        >
            <i class="{{ $icon }} text-xl"></i>
        </div>
    </div>
</div>
