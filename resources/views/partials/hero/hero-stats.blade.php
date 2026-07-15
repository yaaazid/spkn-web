{{--
    3 kotak statistik sejajar, masing-masing rasio 2:1 (lebar:tinggi).
    $stats disuplai dari controller, contoh:
    $stats = [
        ['value' => '2017', 'label' => 'Sejak dibentuk'],
        ['value' => '4', 'label' => 'Unsur komite'],
        ['value' => '7/8', 'label' => 'Tahap proses baku'],
    ];
    Fallback di bawah dipakai kalau variabel belum dikirim (mis. saat development awal).
--}}
@php
    $stats ??= [
        ['value' => '2017', 'label' => 'Sejak dibentuk'],
        ['value' => '4', 'label' => 'Unsur komite'],
        ['value' => '7/8', 'label' => 'Tahap proses baku'],
    ];
@endphp

<div class="spkn-stats">
    @foreach ($stats as $stat)
        <div class="spkn-stats__item glass-panel glass-panel--dark">
            <div class="spkn-stats__value">{{ $stat['value'] }}</div>
            <div class="spkn-stats__label">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>