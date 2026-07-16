{{--
    Komponen header untuk halaman "dalam" (bukan beranda), pola: badge kecil
    + judul besar + deskripsi. Dipakai di committee.history dan nantinya
    halaman "Tentang Kami" lain (struktur komite, tim teknis, tugas) supaya
    satu bahasa visual.

    Pemakaian:
        <x-page-header badge="Tentang Kami" title="..." description="...">
            <!-- opsional: slot untuk baris kartu statistik / konten tambahan -->
            <div class="spkn-page-header__stats"> ... </div>
        </x-page-header>
--}}
@props(['badge', 'title', 'description'])

<section class="spkn-page-header">
    <div class="spkn-page-header__inner">
        <span class="spkn-page-header__badge reveal">{{ $badge }}</span>
        <h1 class="spkn-page-header__title reveal">{{ $title }}</h1>
        <p class="spkn-page-header__desc reveal">{{ $description }}</p>

        {{ $slot }}
    </div>
</section>