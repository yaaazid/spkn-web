{{-- <x-stat-card value="2010" label="Komite pertama dibentuk" /> --}}
@props(['value', 'label'])

<div {{ $attributes->merge(['class' => 'spkn-stat-card reveal']) }}>
    <div class="spkn-stat-card__value">{{ $value }}</div>
    <div class="spkn-stat-card__label">{{ $label }}</div>
</div>