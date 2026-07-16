{{--
    Section "Arsip Keputusan" (Keputusan BPK tentang Komite SPKN) di halaman
    Sejarah — lanjutan dari section "Latar Belakang" (lihat catatan TODO di
    partials/committee/latar-belakang.blade.php & committee/history.blade.php).
    File terpisah sendiri (1 file = 1 section).

    $keputusanBpk BISA disuplai dari controller (mis. dari model CommitteeDecree
    kalau nanti mau dibikin dinamis dari admin — termasuk upload file PDF asli).
    Kalau belum dikirim, dipakai fallback statis di bawah — sudah lengkap 14
    keputusan (2011-2023) sesuai materi yang disuplai.

    Tiap item:
      nomor   : nomor urut tampilan (dua digit, mis. '01')
      title   : teks lengkap "Keputusan BPK No. ... tanggal ..."
      href    : link ke file PDF asli (opsional, fallback '#')

    $catatanArsip : catatan penutup soal keputusan TA 2022 yang belum
    ditandatangani Ketua BPK — BISA disuplai dari controller, fallback statis
    di bawah kalau belum dikirim.
--}}
@php
    $keputusanBpk ??= [
        ['nomor' => '01', 'title' => 'Keputusan BPK No. 1/K/I-XIII.2/3/2011 tanggal 31 Maret 2011.', 'href' => null],
        ['nomor' => '02', 'title' => 'Keputusan BPK No. 8/K/I-XIII.2/12/2012 tanggal 12 Desember 2012.', 'href' => null],
        ['nomor' => '03', 'title' => 'Keputusan BPK No. 7/K/I-XIII.2/12/2013 tanggal 18 Desember 2013.', 'href' => null],
        ['nomor' => '04', 'title' => 'Keputusan BPK No. 8/K/I-XIII.2/9/2014 tanggal 1 September 2014.', 'href' => null],
        ['nomor' => '05', 'title' => 'Keputusan BPK No. 3/K/I-XIII.2/5/2015 tanggal 27 Mei 2015.', 'href' => null],
        ['nomor' => '06', 'title' => 'Keputusan BPK No. 10/K/I-XIII.2/12/2015 tanggal 2 Desember 2015.', 'href' => null],
        ['nomor' => '07', 'title' => 'Keputusan BPK No. 7/K/I-XIII.2/6/2016 tanggal 22 Juni 2016.', 'href' => null],
        ['nomor' => '08', 'title' => 'Keputusan BPK No. 12/K/I-XIII.2/9/2017 tanggal 5 September 2017.', 'href' => null],
        ['nomor' => '09', 'title' => 'Keputusan BPK No. 8/K/I-XIII.2/9/2018 tanggal 4 September 2018.', 'href' => null],
        ['nomor' => '10', 'title' => 'Keputusan BPK No. 6/K/I-XIII.2/8/2019 tanggal 6 Agustus 2019.', 'href' => null],
        ['nomor' => '11', 'title' => 'Keputusan BPK No. 11/K/I-XIII.2/12/2020 tanggal 23 Desember 2020.', 'href' => null],
        ['nomor' => '12', 'title' => 'Keputusan BPK No. 4/K/I-XIII.2/6/2021 tanggal 14 Juni 2021.', 'href' => null],
        ['nomor' => '13', 'title' => 'Keputusan BPK No. 7/K/I-XIII.2/1/2022 tanggal 2 November 2022.', 'href' => null],
        ['nomor' => '14', 'title' => 'Keputusan BPK No. 3/K/I-XIII.2/5/2023 tanggal 29 Mei 2023.', 'href' => null],
    ];

    $catatanArsip ??= 'Keputusan BPK tentang Komite SPKN Tahun Anggaran 2022 belum '
        . 'ditandatangani oleh Ketua BPK karena adanya perubahan susunan Pimpinan '
        . 'Badan. Namun Keputusan Tim Teknis Panitia Kerja Tahun 2022 telah '
        . 'ditetapkan berdasarkan Keputusan Sekjen tanggal 9 Maret 2022.';
@endphp

<section class="spkn-arsip">
    <div class="spkn-arsip__inner">
        <span class="spkn-arsip__badge reveal">Arsip Keputusan</span>
        <h2 class="spkn-arsip__title reveal">Keputusan BPK tentang Komite SPKN</h2>
        <p class="spkn-arsip__desc reveal">
            Rangkaian empat belas Keputusan Ketua BPK terkait pembentukan Komite
            SPKN dari tahun 2011 hingga 2023.
        </p>

        <div class="spkn-arsip__card reveal">
            @foreach ($keputusanBpk as $sk)
                <div class="spkn-arsip__row {{ !empty($sk['highlight']) ? 'is-highlight' : '' }}">
                    <span class="spkn-arsip__num">{{ $sk['nomor'] }}</span>
                    <p class="spkn-arsip__text">{{ $sk['title'] }}</p>
                    <a href="{{ $sk['href'] ?? '#' }}" class="spkn-arsip__pdf">
                        <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                        PDF
                    </a>
                </div>
            @endforeach
        </div>

        <div class="spkn-arsip__note reveal">
            <i class="bi bi-info-circle-fill" aria-hidden="true"></i>
            <p>{{ $catatanArsip }}</p>
        </div>
    </div>
</section>