{{--
    Section "Galeri Momen" di halaman beranda, tampil di bawah unsur-komite.
    Deretan foto yang bergerak terus (marquee) horizontal, loop tanpa putus.

    Frame tiap foto dibuat SERAGAM potret (rasio ±3:4, sudut nyaris siku,
    tanpa rounding besar) mengikuti contoh foto profil resmi (potongan
    dada ke atas, orientasi tegak) -- bukan campuran lebar/sempit seperti
    versi sebelumnya.

    CARA PASANG FOTO ASLI:
    1. Taruh file fotonya di public/assets/images/galeri/ dengan nama file
       PERSIS seperti di kolom 'file' pada $galeriFoto di bawah
       (mis. public/assets/images/galeri/momen-01.png).
    2. Selesai -- begitu file-nya ada, otomatis dipakai, tidak perlu ubah
       kode. Kalau file belum ada, slot-nya tampil sebagai placeholder abu2
       bertulisan "Foto menyusul" supaya kelihatan jelas mana yang masih
       kosong.
    3. Foto TIDAK perlu ukuran/rasio sama persis -- object-fit: cover
       otomatis menyesuaikan ke frame potret yang seragam, tapi hasil
       paling rapi kalau sumbernya juga berorientasi tegak/portrait.
    4. Ganti juga teks 'alt' supaya deskriptif (aksesibilitas & SEO).
    5. Keterangan di bawah foto (pill jabatan + nama miring) OPSIONAL --
       isi 'nama' (dan 'jabatan' kalau ada) cuma untuk foto yang memang
       menampilkan orang tertentu (mis. pimpinan). Kalau 'nama' tidak diisi,
       foto tampil polos tanpa keterangan seperti sebelumnya (cocok buat
       foto suasana/peserta umum yang tidak diberi nama).
    6. Kartu yang punya 'nama' otomatis jadi bisa DIKLIK -> muncul modal
       "Profil" (foto besar, nama, Lahir/Status, akordeon Riwayat
       Pendidikan/Jabatan/Organisasi, tombol LHKPN). Isi datanya lewat key
       tambahan 'lahir', 'status', 'pendidikan' (array baris teks),
       'jabatan_riwayat' (array), 'organisasi' (array), 'penghargaan'
       (array), 'lhkpn' (URL). Kalau belum diisi, bagian itu otomatis
       tampil catatan "data belum tersedia" -- BUKAN dikarang, supaya
       tidak salah info riwayat resmi anggota BPK. 'status' kalau tidak
       diisi barisnya disembunyikan total (bukan tampil "-"), soalnya
       tidak semua sumber resmi mencantumkan status pernikahan.
       Markup modalnya di bagian bawah file ini.

    Barisnya digandakan 2x di markup (lihat @for di bawah) supaya animasi
    geser bisa looping mulus tanpa "patah" -- ini teknik marquee CSS standar,
    bukan foto dobel beneran.
--}}
@php
    $galeriFoto ??= [
        [
            'file' => 'momen-01.png',
            'alt' => 'Foto Dr. Isma Yatun, Ketua BPK',
            'jabatan' => 'Ketua BPK',
            'nama' => 'Dr. Isma Yatun, CSFA., CFrA.',
            'lahir' => '1965',
            'status' => 'Menikah',
        ],
        [
            'file' => 'momen-02.png',
            'alt' => 'Foto Dr. Budi Prijono, Wakil Ketua BPK',
            'jabatan' => 'Wakil Ketua BPK',
            'nama' => 'Dr. Budi Prijono, CFrA., CGCAE., CSFA.',
            'lahir' => '16 Juni 1966',
        ],
        [
            'file' => 'momen-03.png',
            'alt' => 'Foto Dr. Nyoman Adhi Suryadnyana, Anggota I BPK',
            'jabatan' => 'Anggota I BPK',
            'nama' => 'Dr. Nyoman Adhi Suryadnyana, S.E., M.E., M.Ak, CSFA, CertDA, CGCAE, GRCE, CFrA, CIISA, ChFA, Ak, QIA.',
            'lahir' => '1974',
            'status' => 'Menikah',
        ],
        [
            'file' => 'momen-04.png',
            'alt' => 'Foto Ir. Daniel Lumban Tobing, Anggota II BPK',
            'jabatan' => 'Anggota II BPK',
            'nama' => 'Ir. Daniel Lumban Tobing, M.Sc., CSFA., CFrA., CertDA.',
            'lahir' => '1967',
            'status' => 'Menikah',
        ],
        [
            'file' => 'momen-05.png',
            'alt' => 'Foto Prof. Dr. Akhsanul Khaq, Anggota III BPK',
            'jabatan' => 'Anggota III BPK',
            'nama' => 'Prof. Dr. Akhsanul Khaq, M.B.A., CA., CSFA., CPA., CMA., CFrA., Ak.',
            'lahir' => '5 Februari 1967',
        ],
        [
            'file' => 'momen-06.png',
            'alt' => 'Foto Dr. Nyoman Adhi Suryadnyana, PLT Anggota IV BPK',
            'jabatan' => 'PLT Anggota IV BPK',
            'nama' => 'Dr. Nyoman Adhi Suryadnyana, S.E., M.E., M.Ak., CA., CSFA., CFrA., CGCAE.',
            'lahir' => '1974',
            'status' => 'Menikah',
        ],
        [
            'file' => 'momen-07.png',
            'alt' => 'Foto Dr. Bobby Adhityo Rizaldi, Anggota V BPK',
            'jabatan' => 'Anggota V BPK',
            'nama' => 'Dr. Bobby Adhityo Rizaldi, S.E., Ak., MBA., CA., CFE., CSFA.',
            'lahir' => '25 Februari 1974',
        ],
        [
            'file' => 'momen-08.png',
            'alt' => 'Foto Drs. H. Fathan Subchi, Anggota VI BPK',
            'jabatan' => 'Anggota VI BPK',
            'nama' => 'Drs. H. Fathan Subchi, M.A.P., CIISA., ChFA., CSFA.',
            'lahir' => '11 Februari 1970',
        ],
        [
            'file' => 'momen-09.png',
            'alt' => 'Foto Prof. Dr. Slamet Edy Purnomo, Anggota VII BPK',
            'jabatan' => 'Anggota VII BPK',
            'nama' => 'Prof. Dr. Slamet Edy Purnomo, M.M., Ak., CA., CSFA.',
            'lahir' => 'Banyuwangi, 17 Agustus 1964',
        ],
    ];

    $galeriDir = 'assets/images/galeri/';
@endphp

<section class="spkn-galeri" data-navbar-theme="dark">
    <div class="spkn-galeri__head">
        <span class="spkn-galeri__badge reveal">
            <i class="bi bi-people-fill" aria-hidden="true"></i>
            Pimpinan &amp; Anggota
        </span>
        <h2 class="spkn-galeri__title reveal">Pimpinan dan Anggota BPK RI</h2>
    </div>

    <div class="spkn-galeri__viewport">
        <div class="spkn-galeri__track">
            @for ($pass = 0; $pass < 2; $pass++)
                @foreach ($galeriFoto as $key => $foto)
                    @php
                        $path = public_path($galeriDir . $foto['file']);
                        $hasNama = !empty($foto['nama']);
                    @endphp
                    <div class="spkn-galeri__card" @if ($pass === 1) aria-hidden="true" @endif>
                        @if ($hasNama)
                            <button
                                type="button"
                                class="spkn-galeri__trigger"
                                data-bs-toggle="modal"
                                data-bs-target="#profil-momen-{{ $key }}"
                                aria-label="Lihat profil {{ $foto['nama'] }}"
                                @if ($pass === 1) tabindex="-1" @endif
                            >
                        @endif

                        <figure class="spkn-galeri__item">
                            @if (file_exists($path))
                                <img
                                    src="{{ asset($galeriDir . $foto['file']) }}"
                                    alt="{{ $foto['alt'] }}"
                                    loading="lazy"
                                    draggable="false"
                                >
                            @else
                                <div class="spkn-galeri__placeholder">
                                    <i class="bi bi-image" aria-hidden="true"></i>
                                    <span>Foto menyusul</span>
                                </div>
                            @endif
                        </figure>

                        @if ($hasNama)
                            <figcaption class="spkn-galeri__caption">
                                @if (!empty($foto['jabatan']))
                                    <span class="spkn-galeri__caption-jabatan">{{ $foto['jabatan'] }}</span>
                                @endif
                                <span class="spkn-galeri__caption-nama">{{ $foto['nama'] }}</span>
                            </figcaption>
                        @endif

                        @if ($hasNama)
                            </button>
                        @endif
                    </div>
                @endforeach
            @endfor
        </div>
    </div>
</section>

{{--
    Modal profil per orang (cuma foto yang punya 'nama' yang dapat modal).
    Dirender SEKALI per orang (bukan ikut digandakan 2x seperti track di
    atas) -- kedua kartu (pass asli & pass duplikat marquee) sama-sama
    menunjuk ke id modal yang sama lewat data-bs-target, jadi tidak perlu
    & tidak boleh id-nya dobel (id HTML harus unik).
--}}
@foreach ($galeriFoto as $key => $foto)
    @continue(empty($foto['nama']))
    @php
        $path = public_path($galeriDir . $foto['file']);
        $bagianRiwayat = [
            ['key' => 'pendidikan', 'label' => 'Riwayat Pendidikan', 'items' => $foto['pendidikan'] ?? [], 'tone' => 'yellow'],
            ['key' => 'jabatan-riwayat', 'label' => 'Riwayat Jabatan', 'items' => $foto['jabatan_riwayat'] ?? [], 'tone' => 'green'],
            ['key' => 'organisasi', 'label' => 'Riwayat Organisasi', 'items' => $foto['organisasi'] ?? [], 'tone' => 'peach'],
            ['key' => 'penghargaan', 'label' => 'Riwayat Penghargaan', 'items' => $foto['penghargaan'] ?? [], 'tone' => 'blue'],
        ];
    @endphp
    <div class="modal fade" id="profil-momen-{{ $key }}" tabindex="-1" aria-hidden="true" aria-labelledby="profil-momen-{{ $key }}-label">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content spkn-profil__modal">
                <div class="modal-header spkn-profil__modal-head">
                    <h2 class="spkn-profil__modal-title" id="profil-momen-{{ $key }}-label">
                        Profil {{ $foto['jabatan'] ?? 'Anggota' }}
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body spkn-profil__modal-body">
                    <div class="spkn-profil__photo">
                        @if (file_exists($path))
                            <img src="{{ asset($galeriDir . $foto['file']) }}" alt="{{ $foto['alt'] }}" loading="lazy">
                        @else
                            <div class="spkn-profil__photo-placeholder">
                                <i class="bi bi-person-fill" aria-hidden="true"></i>
                            </div>
                        @endif
                    </div>

                    <div class="spkn-profil__banner">{{ $foto['nama'] }}</div>

                    <ul class="spkn-profil__facts">
                        <li>Lahir <strong>{{ $foto['lahir'] ?? '—' }}</strong></li>
                        @if (!empty($foto['status']))
                            <li>Status <strong>{{ $foto['status'] }}</strong></li>
                        @endif
                    </ul>

                    <div class="accordion spkn-profil__accordion" id="accordion-momen-{{ $key }}">
                        @foreach ($bagianRiwayat as $bagian)
                            <div class="accordion-item spkn-profil__accordion-item spkn-profil__accordion-item--{{ $bagian['tone'] }}">
                                <h3 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed spkn-profil__accordion-btn"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $bagian['key'] }}-{{ $key }}"
                                        aria-expanded="false"
                                    >
                                        {{ strtoupper($bagian['label']) }}
                                        <i class="bi bi-chevron-down" aria-hidden="true"></i>
                                    </button>
                                </h3>
                                <div id="collapse-{{ $bagian['key'] }}-{{ $key }}" class="accordion-collapse collapse" data-bs-parent="#accordion-momen-{{ $key }}">
                                    <div class="accordion-body spkn-profil__accordion-body">
                                        @if (!empty($bagian['items']))
                                            <ul>
                                                @foreach ($bagian['items'] as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="spkn-profil__empty-note">
                                                Data {{ strtolower($bagian['label']) }} resmi belum tersedia di halaman ini.
                                                Untuk informasi terverifikasi, kunjungi laman profil BPK RI.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a
                        href="{{ $foto['lhkpn'] ?? 'https://elhkpn.kpk.go.id/' }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="spkn-profil__lhkpn"
                    >
                        <i class="bi bi-upc-scan" aria-hidden="true"></i> LHKPN
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach