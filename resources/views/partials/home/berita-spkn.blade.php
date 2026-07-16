{{--
    Section "Berita SPKN" di halaman beranda — berita utama + sidebar
    (pencarian, sosial media, foto dokumentasi, kalender kegiatan).

    $beritaUtama & $beritaLain BISA disuplai dari controller (mis. dari model
    News/Berita kalau nanti mau dibikin dinamis dari admin). Fallback statis
    di bawah dipakai kalau belum dikirim.

    Kalender SPKN dirender otomatis mengikuti bulan berjalan lewat PHP
    (Carbon), lalu navigasi bulan berikutnya/sebelumnya di-handle client-side
    oleh resources/js/modules/kalender-spkn.js (tanpa perlu reload halaman).
--}}
@php
    $beritaUtama ??= [
        'kategori' => 'Kegiatan',
        'judul'    => 'Komite SPKN Gelar Pembahasan Rancangan Perubahan SPKN Tahun 2026',
        'ringkasan' => 'Pembahasan difokuskan pada penyelarasan standar pemeriksaan dengan '
            . 'perkembangan praktik terbaik internasional serta masukan dari pemangku '
            . 'kepentingan selama masa uji publik terbatas.',
        'tanggal'  => '14 Juli 2026',
        'sumber'   => 'Humas BPK RI',
    ];

    $beritaLain ??= [
        [
            'kategori' => 'Publikasi',
            'judul'    => 'Ringkasan Hasil Uji Publik Terbatas Draf SPKN',
            'tanggal'  => '10 Juli 2026',
        ],
        [
            'kategori' => 'Agenda',
            'judul'    => 'Jadwal Forum Konsultasi Publik Bulan Agustus 2026',
            'tanggal'  => '5 Juli 2026',
        ],
        [
            'kategori' => 'Kegiatan',
            'judul'    => 'Kunjungan Kerja Komite SPKN ke Perwakilan BPK Provinsi',
            'tanggal'  => '28 Juni 2026',
        ],
    ];

    $sosmed ??= [
        ['slug' => 'facebook',  'icon' => 'bi-facebook',  'nama' => 'Facebook',    'href' => 'https://www.facebook.com/humasbpkri.official/'],
        ['slug' => 'x',         'icon' => 'bi-twitter-x', 'nama' => 'X (Twitter)', 'href' => 'https://x.com/bpkri'],
        ['slug' => 'instagram', 'icon' => 'bi-instagram', 'nama' => 'Instagram',   'href' => 'https://www.instagram.com/bpkriofficial/'],
        ['slug' => 'youtube',   'icon' => 'bi-youtube',   'nama' => 'YouTube',     'href' => 'https://www.youtube.com/c/BPKRIOfficial'],
        ['slug' => 'whatsapp',  'icon' => 'bi-whatsapp',  'nama' => 'WhatsApp',    'href' => '#'],
        ['slug' => 'tiktok',    'icon' => 'bi-tiktok',    'nama' => 'TikTok',      'href' => 'https://www.tiktok.com/@bpk.ri'],
    ];

    // Nama hari disesuaikan urutan Senin–Minggu, dipakai juga oleh JS saat
    // render ulang kalender ketika pindah bulan.
    $namaHari = ['S', 'S', 'R', 'K', 'J', 'S', 'M'];

    $bulanIni   = \Carbon\Carbon::now();
    $namaBulan  = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $labelBulan = strtoupper($namaBulan[$bulanIni->month - 1] . ' ' . $bulanIni->year);

    // Senin = 0 ... Minggu = 6, dipakai untuk menentukan berapa sel kosong di awal grid.
    $mulaiBulan   = $bulanIni->copy()->startOfMonth();
    $offsetAwal   = ($mulaiBulan->dayOfWeekIso - 1);
    $jumlahHari   = $bulanIni->daysInMonth;
    $hariIni      = $bulanIni->day;
@endphp

<section class="spkn-berita">
    <div class="spkn-berita__inner">
        <div class="spkn-berita__head">
            <div>
                <span class="spkn-berita__badge">Kabar Terbaru</span>
                <h2 class="spkn-berita__title">Berita SPKN</h2>
            </div>
            <a href="{{ route('home') }}" class="spkn-berita__cta">
                Berita Lainnya <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="spkn-berita__layout">
            {{-- Kolom utama: berita utama + daftar berita lain --}}
            <div class="spkn-berita__main">
                <article class="spkn-berita__featured">
                    <div class="spkn-berita__featured-media">
                        <i class="bi bi-image" aria-hidden="true"></i>
                    </div>
                    <div class="spkn-berita__featured-body">
                        <span class="spkn-berita__tag">{{ $beritaUtama['kategori'] }}</span>
                        <h3 class="spkn-berita__featured-title">{{ $beritaUtama['judul'] }}</h3>
                        <p class="spkn-berita__featured-desc">{{ $beritaUtama['ringkasan'] }}</p>
                        <div class="spkn-berita__meta">
                            <span><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $beritaUtama['tanggal'] }}</span>
                            <span><i class="bi bi-building" aria-hidden="true"></i> {{ $beritaUtama['sumber'] }}</span>
                        </div>
                    </div>
                </article>

                <div class="spkn-berita__list">
                    @foreach ($beritaLain as $berita)
                        <a href="{{ route('home') }}" class="spkn-berita__list-item">
                            <div class="spkn-berita__list-thumb">
                                <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                            </div>
                            <div class="spkn-berita__list-body">
                                <span class="spkn-berita__tag spkn-berita__tag--sm">{{ $berita['kategori'] }}</span>
                                <h4 class="spkn-berita__list-title">{{ $berita['judul'] }}</h4>
                                <span class="spkn-berita__list-date">{{ $berita['tanggal'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar: pencarian, sosial media, foto, kalender --}}
            <aside class="spkn-berita__aside">
                <form action="{{ route('home') }}" method="get" class="spkn-berita__search">
                    <input
                        type="search"
                        name="q"
                        class="spkn-berita__search-input"
                        placeholder="Pencarian..."
                        aria-label="Pencarian"
                    >
                    <button type="submit" class="spkn-berita__search-btn">Cari</button>
                </form>

                <div class="spkn-berita__social">
                    @foreach ($sosmed as $sm)
                        <a
                            href="{{ $sm['href'] }}"
                            class="spkn-berita__social-btn spkn-berita__social-btn--{{ $sm['slug'] }}"
                            aria-label="{{ $sm['nama'] }}"
                            title="{{ $sm['nama'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i class="bi {{ $sm['icon'] }}" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>

                <div class="spkn-berita__photo">
                    <i class="bi bi-camera-fill" aria-hidden="true"></i>
                    <span>Dokumentasi Kegiatan</span>
                </div>

                <div class="spkn-berita__calendar" data-kalender-spkn data-hari-ini="{{ $hariIni }}" data-tahun="{{ $bulanIni->year }}" data-bulan="{{ $bulanIni->month }}">
                    <span class="spkn-berita__badge spkn-berita__badge--calendar">
                        <i class="bi bi-calendar-week" aria-hidden="true"></i> Kalender SPKN
                    </span>

                    <div class="spkn-berita__calendar-nav">
                        <button type="button" class="spkn-berita__calendar-arrow" data-kalender-prev aria-label="Bulan sebelumnya">
                            <i class="bi bi-chevron-left" aria-hidden="true"></i>
                        </button>
                        <span class="spkn-berita__calendar-label" data-kalender-label>{{ $labelBulan }}</span>
                        <button type="button" class="spkn-berita__calendar-arrow" data-kalender-next aria-label="Bulan berikutnya">
                            <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="spkn-berita__calendar-grid" data-kalender-grid>
                        @foreach ($namaHari as $h)
                            <span class="spkn-berita__calendar-dow">{{ $h }}</span>
                        @endforeach

                        @for ($i = 0; $i < $offsetAwal; $i++)
                            <span class="spkn-berita__calendar-day is-empty"></span>
                        @endfor

                        @for ($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                            <span class="spkn-berita__calendar-day @if($tgl === $hariIni) is-today @endif">{{ $tgl }}</span>
                        @endfor
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>