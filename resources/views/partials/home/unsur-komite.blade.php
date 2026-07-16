{{--
    Section "Unsur Komite" di halaman beranda.
    Sengaja dipisah dari hero.blade.php jadi file sendiri (1 file = 1 section)
    supaya hero.blade.php tidak menumpuk terus makin panjang tiap nambah section baru.

    $unsurKomite BISA disuplai dari controller (mis. dari model CommitteeElement
    kalau nanti mau dibikin dinamis dari admin). Kalau belum dikirim, dipakai
    fallback statis di bawah — sesuai konten di desain.
--}}
@php
    $unsurKomite ??= [
        [
            'icon'   => 'bi-building',
            'accent' => 'indigo',
            'title'  => 'Dewan Konsultatif',
            'desc'   => 'Unsur pengarah Komite SPKN.',
        ],
        [
            'icon'   => 'bi-award',
            'accent' => 'gold',
            'title'  => 'Panitia Kerja',
            'desc'   => 'Unsur pelaksana kegiatan komite.',
        ],
        [
            'icon'   => 'bi-tools',
            'accent' => 'teal',
            'title'  => 'Tim Teknis',
            'desc'   => 'Unsur pembantu panitia kerja.',
        ],
        [
            'icon'   => 'bi-folder-fill',
            'accent' => 'purple',
            'title'  => 'Sekretariat',
            'desc'   => 'Unsur pendukung panitia kerja dan tim teknis.',
        ],
    ];
@endphp

<section class="spkn-unsur">
    <div class="spkn-unsur__inner">
        <span class="spkn-unsur__badge reveal">Siapa Kami</span>

        <h2 class="spkn-unsur__title reveal">Empat unsur, satu standar</h2>

        <p class="spkn-unsur__desc reveal">
            Komite SPKN dibentuk berdasarkan Peraturan BPK Nomor 1 Tahun 2017 tentang
            Standar Pemeriksaan Keuangan Negara, dan bertugas mengevaluasi penerapan
            serta pengembangan SPKN.
        </p>

        <div class="spkn-unsur__grid">
            @foreach ($unsurKomite as $unsur)
                <div class="spkn-unsur__card reveal">
                    <div class="spkn-unsur__icon spkn-unsur__icon--{{ $unsur['accent'] }}">
                        <i class="bi {{ $unsur['icon'] }}" aria-hidden="true"></i>
                    </div>
                    <h3 class="spkn-unsur__card-title">{{ $unsur['title'] }}</h3>
                    <p class="spkn-unsur__card-desc">{{ $unsur['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>