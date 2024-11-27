@props(['active', 'icon', 'message' => null])

@php
    $classes = $active ? 'font-bold dark:!text-gray-100' : 'hover:text-black dark:hover:text-white group';
    $classIcon = $icon ? $icon : 'fa-solid fa-question';
@endphp

<a
    {{ $attributes->merge(['class' => 'block text-gray-800 dark:text-gray-300 group truncate transition ' . $classes]) }}>
    <div class="flex items-center justify-center sidebar-expanded:justify-between">
        <div class="flex items-center">
            <span
                class="@if ($active) {{ 'text-yellow-600' }}@else{{ 'text-gray-400 dark:text-gray-500 group-hover:text-gray-800 group-hover:dark:text-gray-100 duration-500' }} @endif">
                <i class="{{ $classIcon }} fa-fw"></i>
            </span>
            <span
                class="text-sm ml-3 lg:hidden lg:sidebar-expanded:block 2xl:opacity-100 duration-200">{{ $slot }}</span>
        </div>
        <!-- Badge -->
        @if ($message)
            <div class="flex flex-shrink-0 ml-2 lg:hidden lg:sidebar-expanded:flex">
                <span
                    class="inline-flex items-center justify-center h-5 text-xs font-medium text-white bg-red-600 px-2 rounded">4</span>
            </div>
        @endif
    </div>
</a>
