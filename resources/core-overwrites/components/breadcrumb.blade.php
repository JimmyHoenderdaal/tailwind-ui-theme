@props(['url', 'position', 'active' => false])

<li class="text-tut-inactive flex items-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    @if (!$active)
        <a {{ $attributes->merge(['class' => 'text-sm hover:underline', 'href' => url($url), 'itemprop' => 'item']) }}>
            <span itemprop="name">{{ $slot }}</span>
            <meta itemprop="position" content="{{ $position }}" />
        </a>
        <x-heroicon-s-chevron-right class="h-4 w-4" />
    @else
        <span class="text-sm" itemprop="name">{{ $slot }}</span>
        <meta itemprop="position" content="{{ $position }}" />
    @endif
</li>
