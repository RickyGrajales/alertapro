@props(['route', 'icon' => null])

@php
    $active = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex items-center px-4 py-2 rounded-md text-sm font-medium transition-all duration-200
          {{ $active
                ? 'bg-blue-600 text-white shadow-inner'
                : 'text-gray-200 hover:bg-blue-700 hover:text-white' }}">
    @if($icon)
        <i class="fas {{ $icon }} mr-2"></i>
    @endif
    {{ $slot }}
</a>
