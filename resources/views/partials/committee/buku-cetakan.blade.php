{{--
    Section "Buku Cetakan Publikasi" di halaman Perpustakaan/Dokumentasi.
    File terpisah sendiri (1 file = 1 section) mengikuti pola di partials/home/*.

    $bukuCetakan BISA disuplai dari controller (mis. dari model Publication kalau
    nanti mau dibikin dinamis dari admin — termasuk upload cover asli). Kalau
    belum dikirim, dipakai fallback statis di bawah.

    Tiap item:
      title    : judul buku
      subtitle : anak judul / rentang tahun (opsional)
      meta     : teks dasar hukum kecil di cover (opsional)
      accent   : 'green' | 'blue' | 'orange' — palet cover kalau belum ada cover asli
      image    : path cover asli (opsional). Kalau diisi, dipakai gambar asli
                 menggantikan cover CSS.
      href     : link ke halaman detail/unduhan (opsional, fallback '#')
--}}
@php
    $bukuCetakan ??= [
        [
            'title'    => 'KPSPKN',
            'subtitle' => 'Kerangka Penyusunan Standar Pemeriksaan Keuangan Negara',
            'meta'     => 'Keputusan Badan Pemeriksa Keuangan Republik Indonesia',
            'accent'   => 'green',
            'image'    => null,
            'href'     => null,
        ],
        [
            'title'    => 'Standar Pemeriksaan Keuangan Negara',
            'subtitle' => null,
            'meta'     => 'Peraturan Badan Pemeriksa Keuangan Republik Indonesia Nomor 1 Tahun 2017',
            'accent'   => 'blue',
            'image'    => null,
            'href'     => null,
        ],
        [
            'title'    => 'Konsep Rencana Pengembangan Strategis',
            'subtitle' => '2020–2024',
            'meta'     => null,
            'accent'   => 'orange',
            'image'    => null,
            'href'     => null,
        ],
    ];
@endphp

<section class="spkn-buku">
    <div class="spkn-buku__inner">
        <span class="spkn-buku__badge reveal">Dokumentasi</span>
        <h2 class="spkn-buku__title reveal">Buku Cetakan Publikasi</h2>

        <div class="spkn-buku__grid">
            @foreach ($bukuCetakan as $buku)
                <a href="{{ $buku['href'] ?? '#' }}" class="spkn-buku__card reveal">
                    @if (!empty($buku['image']))
                        <img
                            src="{{ $buku['image'] }}"
                            alt="Sampul buku {{ $buku['title'] }}"
                            class="spkn-buku__cover-img"
                            loading="lazy"
                        >
                    @else
                        <div class="spkn-buku__cover spkn-buku__cover--{{ $buku['accent'] }}">
                            @if ($buku['accent'] === 'orange')
                                <span class="spkn-buku__year">{{ $buku['subtitle'] }}</span>
                            @endif

                            <div class="spkn-buku__cover-body">
                                @if ($buku['meta'])
                                    <p class="spkn-buku__meta">{{ $buku['meta'] }}</p>
                                @endif

                                <h3 class="spkn-buku__cover-title">{{ $buku['title'] }}</h3>

                                @if ($buku['subtitle'] && $buku['accent'] !== 'orange')
                                    <p class="spkn-buku__subtitle">{{ $buku['subtitle'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>