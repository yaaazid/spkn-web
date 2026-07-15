{{--
    $stats disuplai dari controller, contoh:
    $stats = [
        ['icon' => 'bi-people-fill', 'value' => '1.500+', 'label' => 'Pengunjung Bulan Ini'],
        ['icon' => 'bi-file-earmark-text-fill', 'value' => '120+', 'label' => 'Dokumen SPKN'],
    ];
    Fallback di bawah dipakai kalau variabel belum dikirim (mis. saat development awal).
--}}
@php
    $stats ??= [
        ['icon' => 'bi-people-fill', 'value' => '1.500+', 'label' => 'Pengunjung Bulan Ini'],
        ['icon' => 'bi-file-earmark-text-fill', 'value' => '120+', 'label' => 'Dokumen SPKN'],
    ];
@endphp

<div class="spkn-stats glass-panel glass-panel--dark">
    @foreach ($stats as $stat)
        <div class="spkn-stats__item">
            <span class="spkn-stats__icon">
                <i class="bi {{ $stat['icon'] }}" aria-hidden="true"></i>
            </span>
            <div>
                <div class="spkn-stats__value">{{ $stat['value'] }}</div>
                <div class="spkn-stats__label">{{ $stat['label'] }}</div>
            </div>
        </div>
    @endforeach

    <div class="spkn-stats__divider"></div>

    <a href="{{ route('stats.index') ?? '#' }}" class="spkn-stats__link">
        Lihat Statistik
        <i class="bi bi-arrow-right" aria-hidden="true"></i>
    </a>
</div>