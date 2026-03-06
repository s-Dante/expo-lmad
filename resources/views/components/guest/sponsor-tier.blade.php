@props(['tier'])

@php
    $class = match (strtolower($tier)) {
        'titanium' => 'tier-titanium',
        'diamante', 'diamond' => 'tier-diamond',
        'oro', 'gold' => 'tier-gold',
        'plata', 'silver' => 'tier-silver',
        'bronce', 'bronze' => 'tier-bronch',
        default => 'tier-' . strtolower($tier),
    };
@endphp

<div class="sponsor-tier">
    <p class="{{ $class }}">{{ $tier }}</p>
</div>