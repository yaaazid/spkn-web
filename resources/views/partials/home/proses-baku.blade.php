{{--
    Section "Proses Baku" (Delapan tahapan proses baku) di halaman beranda.
    File terpisah dari unsur-komite.blade.php & hero.blade.php (1 file = 1 section).

    $tahapanProsesBaku BISA disuplai dari controller (mis. dari model SpknRevision
    kalau nanti mau dibikin dinamis dari admin — status tiap tahap diupdate dari
    panel admin). Kalau belum dikirim, dipakai fallback statis di bawah.

    status yang valid: 'selesai', 'proses', 'menunggu'
--}}
@php
    $tahapanProsesBaku ??= [
        ['title' => 'Kajian awal', 'status' => 'selesai'],
        ['title' => 'Penyusunan draft', 'status' => 'selesai'],
        ['title' => 'Pembahasan internal', 'status' => 'selesai'],
        ['title' => 'Uji publik terbatas', 'status' => 'selesai'],
        ['title' => 'Penyempurnaan draft', 'status' => 'selesai'],
        ['title' => 'Pembahasan dengan pihak terkait', 'status' => 'selesai'],
        ['title' => 'Finalisasi draft', 'status' => 'proses'],
        ['title' => 'Penerbitan', 'status' => 'menunggu'],
    ];

    $statusMeta = [
        'selesai'  => ['icon' => 'bi-check-lg', 'label' => 'Selesai'],
        'proses'   => ['icon' => 'bi-hourglass-split', 'label' => 'Dalam proses'],
        'menunggu' => ['icon' => 'bi-three-dots', 'label' => 'Menunggu'],
    ];
@endphp

<section class="spkn-proses-section">
    <div class="spkn-proses">
        <span class="spkn-proses__badge reveal">
            <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
            Apa yang Kami Kerjakan
        </span>

        <h2 class="spkn-proses__title reveal">Delapan tahapan proses baku</h2>

        <p class="spkn-proses__desc reveal">
            Komite SPKN telah menyusun Draf Eksposur (DE) Revisi SPKN Tahun 2022
            sebagai penyempurnaan SPKN 2017 melalui delapan tahapan proses baku.
            Setiap tahap dicentang begitu selesai.
        </p>

        <div class="spkn-proses__scroller reveal" data-proses-scroller>
            <div class="spkn-proses__track">
                @foreach ($tahapanProsesBaku as $i => $tahap)
                    @php $meta = $statusMeta[$tahap['status']]; @endphp
                    <div class="spkn-proses__card">
                        <div class="spkn-proses__icon spkn-proses__icon--{{ $tahap['status'] }}">
                            <i class="bi {{ $meta['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <div class="spkn-proses__number">{{ $i + 1 }}</div>
                        <h3 class="spkn-proses__card-title">{{ $tahap['title'] }}</h3>
                        <span class="spkn-proses__status spkn-proses__status--{{ $tahap['status'] }}">
                            <i class="bi {{ $meta['icon'] }}" aria-hidden="true"></i>
                            {{ $meta['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="spkn-proses__scrollbar">
            <button type="button" class="spkn-proses__arrow" data-proses-prev aria-label="Tahap sebelumnya">
                <i class="bi bi-chevron-left" aria-hidden="true"></i>
            </button>
            <div class="spkn-proses__scrollbar-track" data-proses-track>
                <div class="spkn-proses__scrollbar-thumb" data-proses-thumb></div>
            </div>
            <button type="button" class="spkn-proses__arrow" data-proses-next aria-label="Tahap berikutnya">
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>
        </div>

        <p class="spkn-proses__hint">← Geser untuk melihat semua tahap →</p>
    </div>
</section>