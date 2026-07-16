{{--
    Hero card untuk halaman struktur organisasi (Dewan Konsultatif, Panitia
    Kerja, Sekretariat SPKN). Judul & deskripsi menyesuaikan $param yang aktif
    supaya selalu konsisten dengan bagan di bawahnya (di reference lama judul
    hero pernah kelihatan tidak sinkron sama bagan — sengaja dihindari di sini
    dengan menghitung ulang dari $param yang sama, bukan nilai statis terpisah).
--}}
@php
    $labelUnsur = match ($param ?? null) {
        'dewan-konsultatif' => 'Dewan Konsultatif',
        'panitia-kerja'     => 'Panitia Kerja',
        'sekretariat-spkn'  => 'Sekretariat SPKN',
        default             => 'Komite SPKN',
    };

    $deskripsiUnsur = match ($param ?? null) {
        'dewan-konsultatif' => 'Bagan berikut menunjukkan susunan Dewan Konsultatif Komite SPKN. Klik salah satu kartu untuk melihat profil singkat masing-masing anggota.',
        'panitia-kerja'     => 'Bagan berikut menunjukkan susunan Panitia Kerja Komite SPKN.',
        'sekretariat-spkn'  => 'Bagan berikut menunjukkan susunan Sekretariat Komite SPKN.',
        default             => 'Bagan struktur organisasi Komite SPKN.',
    };
@endphp

<section class="spkn-struktur-hero">
    <div class="spkn-struktur-hero__inner">
        <div class="spkn-struktur-hero__card">
            <span class="spkn-struktur-hero__badge">Struktur Organisasi</span>
            <h1 class="spkn-struktur-hero__title">{{ $labelUnsur }}</h1>
            <p class="spkn-struktur-hero__desc">{{ $deskripsiUnsur }}</p>
        </div>
    </div>
</section>