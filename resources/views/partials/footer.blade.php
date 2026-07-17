{{--
    Footer — dipakai di semua halaman publik lewat layouts/app.blade.php.
    $kontak BISA disuplai dari controller kalau nanti mau dibikin dinamis
    dari admin. Fallback statis di bawah dipakai kalau belum dikirim.

    Section kontak penuh ("Kami siap membantu" + kartu alamat/telp/email/jam
    kerja) CUMA tampil di Beranda. Di halaman lain footer-nya diringkas jadi
    bar copyright doang (lihat .spkn-footer--compact di _footer.css) —
    otomatis dideteksi dari route aktif, tidak perlu diatur manual per halaman.
--}}
@php
    $isHome = request()->routeIs('home');

    $kontak ??= [
        [
            'icon'  => 'bi-geo-alt-fill',
            'title' => 'Alamat',
            'lines' => [
                'Sekretariat Komite SPKN',
                'Badan Pemeriksa Keuangan RI',
                'Gedung Arsip Lantai 2',
                'Jl. Gatot Subroto Kav. 31, Jakarta Pusat 10210',
            ],
            'maps_url' => 'https://www.google.com/maps/place/?q=place_id:ChIJYRGTVbr2aS4RIqoUDnVCjPY',
        ],
        [
            'icon'  => 'bi-telephone-fill',
            'title' => 'Kontak Kami',
            'lines' => ['+6221 2554 9000', 'Ext. 3296'],
        ],
        [
            'icon'  => 'bi-envelope-fill',
            'title' => 'Alamat Email',
            'lines' => ['komite.spkn@bpk.go.id'],
        ],
        [
            'icon'  => 'bi-clock-fill',
            'title' => 'Jam Kerja',
            'lines' => ['Senin – Jumat', '09.00 – 15.00 WIB'],
        ],
    ];
@endphp

<footer class="spkn-footer {{ $isHome ? '' : 'spkn-footer--compact' }}" data-navbar-theme="dark">
    <div class="spkn-footer__inner">
        @if ($isHome)
            <span class="spkn-footer__badge">Hubungi Kami</span>
            <h2 class="spkn-footer__title">Kami siap membantu</h2>

            <div class="spkn-footer__grid">
                @foreach ($kontak as $item)
                    @php
                        $isLink = isset($item['maps_url']);
                        $tag    = $isLink ? 'a' : 'div';
                    @endphp
                    <{{ $tag }}
                        class="spkn-footer__card{{ $isLink ? ' spkn-footer__card--link' : '' }}"
                        @if ($isLink)
                            href="{{ $item['maps_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="Buka lokasi di Google Maps"
                        @endif
                    >
                        <div class="spkn-footer__icon">
                            <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <h3 class="spkn-footer__card-title">{{ $item['title'] }}</h3>
                        @foreach ($item['lines'] as $line)
                            <div class="spkn-footer__card-line">{{ $line }}</div>
                        @endforeach
                    </{{ $tag }}>
                @endforeach
            </div>
        @endif

        <div class="spkn-footer__bottom">
            <span>&copy; Copyright <strong>SPKN</strong>. All Rights Reserved</span>
            <span>Designed by <a href="{{ route('home') }}">SPKN BPK-RI</a></span>
            @if ($isHome)
                <button type="button" class="spkn-footer__settings" aria-label="Pengaturan">
                    <i class="bi bi-gear" aria-hidden="true"></i>
                </button>
            @endif
        </div>
    </div>
</footer>

<button type="button" class="spkn-back-to-top" data-back-to-top aria-label="Kembali ke atas">
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>