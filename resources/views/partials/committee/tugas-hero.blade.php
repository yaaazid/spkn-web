{{--
    Section hero halaman "Tugas" (Tentang Kami > Tugas). Beda dari halaman
    Tentang Kami lain (Sejarah, Struktur Komite) yang pakai <x-page-header>
    polos di tengah -- di sini butuh layout 2 kolom (teks + gambar) sesuai
    referensi desain, jadi dibikin partial sendiri, BUKAN lewat komponen
    <x-page-header>.

    File terpisah sendiri (1 file = 1 section) mengikuti pola di
    partials/committee/* & partials/home/* lainnya.

    $tugasStat & gambar BISA disuplai dari controller kalau nanti datanya mau
    dibikin dinamis dari admin. Kalau belum dikirim, dipakai fallback statis
    di bawah -- ANGKA "19 total tugas & fungsi" masih PLACEHOLDER, tunggu
    rincian tugas resmi tiap unsur (Dewan Konsultatif/Panitia Kerja/Tim
    Teknis/Sekretariat) sebelum dipakai final, supaya tidak salah angka.

    Foto di kolom kanan juga masih placeholder (fallback gradient + ikon)
    karena belum ada aset foto asli di public/assets/images. Begitu foto
    asli (mis. "tugas-hero.jpg") sudah diupload, isi variabel $tugasImage
    dari controller/route, nanti otomatis dipakai menggantikan placeholder.
--}}
@php
    $tugasImage ??= null;

    $tugasStat ??= [
        ['value' => '4', 'label' => 'Unsur komite'],
        ['value' => '19', 'label' => 'Total tugas & fungsi'],
        ['value' => '1', 'label' => 'Standar bersama'],
    ];
@endphp

<section class="spkn-tugas-hero">
    <div class="spkn-tugas-hero__inner">
        <div class="spkn-tugas-hero__content">
            <span class="spkn-tugas-hero__badge reveal">
                <i class="bi bi-clipboard-check" aria-hidden="true"></i>
                Struktur &amp; Kewenangan
            </span>

            <h1 class="spkn-tugas-hero__title reveal">
                Tugas yang jelas untuk setiap unsur komite.
            </h1>

            <p class="spkn-tugas-hero__desc reveal">
                Dari pengarahan hingga pelaksanaan, setiap unsur Komite SPKN memiliki
                peran yang saling melengkapi dalam menjaga mutu Standar Pemeriksaan
                Keuangan Negara.
            </p>

            <div class="spkn-tugas-hero__stats">
                @foreach ($tugasStat as $stat)
                    <x-stat-card value="{{ $stat['value'] }}" label="{{ $stat['label'] }}" />
                @endforeach
            </div>
        </div>

        <div class="spkn-tugas-hero__visual reveal">
            <div class="spkn-tugas-hero__frame">
                @if ($tugasImage)
                    <img
                        src="{{ $tugasImage }}"
                        alt="Standar Pemeriksaan Keuangan Negara"
                        class="spkn-tugas-hero__img"
                        loading="lazy"
                    >
                @else
                    <div class="spkn-tugas-hero__placeholder">
                        <i class="bi bi-journal-bookmark-fill" aria-hidden="true"></i>
                    </div>
                @endif
            </div>

            <div class="spkn-tugas-hero__card">
                <h3 class="spkn-tugas-hero__card-title">Satu rantai kerja</h3>
                <p class="spkn-tugas-hero__card-desc">
                    Dewan mengarahkan, Panitia melaksanakan, Tim Teknis mengkaji,
                    Sekretariat mendukung.
                </p>
            </div>
        </div>
    </div>
</section>