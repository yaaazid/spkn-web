{{--
    Komponen: <x-nav-flyout-panel :items="$items" />
    Dipakai untuk submenu tingkat dua yang muncul di sisi kanan item induk,
    contoh: "Struktur Tim Teknis" -> daftar 8 tim teknis.
--}}
@props(['items' => []])

<div class="spkn-flyout glass-panel" data-flyout-panel>
    <ul class="spkn-dropdown__list">
        @foreach ($items as $flyout)
            <li>
                <a
                    href="{{ Route::has($flyout['route'] ?? null) ? route($flyout['route'], $flyout['param'] ?? null) : '#' }}"
                    class="spkn-flyout__link"
                >
                    <span class="spkn-flyout__icon">
                        <i class="bi bi-people" aria-hidden="true"></i>
                    </span>
                    <span>{{ $flyout['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>