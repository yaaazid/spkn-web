{{--
    Bagan struktur organisasi 1 unsur komite (Dewan Konsultatif, Panitia Kerja,
    dst). Dipakai oleh:
      - committee/structure.blade.php      (landing /tentang/struktur-komite, default 'dewan-konsultatif')
      - committee/structure-show.blade.php (/tentang/struktur-komite/{param})

    $param  : slug unsur yang aktif, dikirim dari route (lihat routes/web.php)
    $unsur  : BISA disuplai dari controller/model kalau nanti datanya dipindah
              ke database (mis. tabel committee_members). Fallback statis di
              bawah dipakai kalau belum dikirim — datanya mengikuti susunan
              resmi BPK RI per periode 2024-2029 (sumber: bpk.go.id/menu/profil_bpk).

    Catatan struktur "panitia-kerja": jenjangnya lebih dalam dari Dewan
    Konsultatif (Penanggung Jawab -> Wakil Penanggung Jawab -> Ketua, lalu
    Ketua bercabang ke Sekretaris & Anggota), jadi dipakai key tambahan
    'penanggung_jawab', 'wakil_penanggung_jawab', dan 'sekretaris' di bawah.
    Kalau key-key itu tidak ada (mis. dewan-konsultatif), bagan otomatis
    fallback ke layout lama (ketua/wakil/anggota, 3 level).
--}}
@php
    $dataUnsur ??= [
        'dewan-konsultatif' => [
            'judul' => 'Dewan Konsultatif',
            'ketua' => [
                'nama' => 'Isma Yatun',
                'jabatan' => 'Ketua merangkap Anggota',
            ],
            'wakil' => [
                'nama' => 'Budi Prijono',
                'jabatan' => 'Wakil Ketua merangkap Anggota',
            ],
            'anggota' => [
                ['nama' => 'Nyoman Adhi Suryadnyana', 'jabatan' => 'Anggota I'],
                ['nama' => 'Daniel Lumban Tobing',     'jabatan' => 'Anggota II'],
                ['nama' => 'Akhsanul Khaq',            'jabatan' => 'Anggota III'],
                ['nama' => 'Nyoman Adhi Suryadnyana',  'jabatan' => 'PLT Anggota IV'],
                ['nama' => 'Bobby Adhityo Rizaldi',    'jabatan' => 'Anggota V'],
                ['nama' => 'Fathan Subchi',            'jabatan' => 'Anggota VI'],
                ['nama' => 'Slamet Edy Purnomo',       'jabatan' => 'Anggota VII'],
            ],
        ],
        'panitia-kerja' => [
            'judul' => 'Panitia Kerja',
            'penanggung_jawab' => [
                'nama' => 'Bahtiar Arif',
                'jabatan' => 'Penanggung Jawab',
            ],
            'wakil_penanggung_jawab' => [
                'nama' => 'Bernardus Dwita Pradana',
                'jabatan' => 'Wakil Penanggung Jawab',
            ],
            'ketua' => [
                'nama' => 'Nelson Ambarita',
                'jabatan' => 'Ketua',
            ],
            'wakil' => null,
            'sekretaris' => [
                'nama' => 'Selvia Vivi Devianti',
                'jabatan' => 'Sekretaris',
            ],
            'anggota' => [
                ['nama' => 'Akhsanul Khaq',                    'jabatan' => 'Anggota'],
                ['nama' => 'Ahmad Adib Susilo',                'jabatan' => 'Anggota'],
                ['nama' => 'Syamsudin',                        'jabatan' => 'Anggota'],
                ['nama' => 'Slamet Kurniawan',                 'jabatan' => 'Anggota'],
                ['nama' => 'Laode Nusriadi',                   'jabatan' => 'Anggota'],
                ['nama' => 'Novy Gregory Antonius Pelenkahu',  'jabatan' => 'Anggota'],
                ['nama' => 'Hery Subowo',                      'jabatan' => 'Anggota'],
                ['nama' => 'I Nyoman Wara',                    'jabatan' => 'Anggota'],
                ['nama' => 'Akhmad Anang Hernady',             'jabatan' => 'Anggota'],
                ['nama' => 'Beni Ruslandi',                    'jabatan' => 'Anggota'],
                ['nama' => 'Dori Santosa',                     'jabatan' => 'Anggota'],
                ['nama' => 'Novian Herodwijanto',              'jabatan' => 'Anggota'],
                ['nama' => 'Edward Ganda Hasiholan S',         'jabatan' => 'Anggota'],
                ['nama' => 'Dadang Ahmad Rifa`i',               'jabatan' => 'Anggota'],
                ['nama' => 'Suwarni Dyah Setyaningsih',        'jabatan' => 'Anggota'],
            ],
        ],
        'sekretariat-spkn' => [
            'judul' => 'Sekretariat SPKN',
            'legend_ketua' => 'Kepala',
            'ketua' => [
                'nama' => 'Basiswanto Wiratama',
                'jabatan' => 'Kepala',
            ],
            'wakil' => null,
            'anggota' => [
                ['nama' => 'Kodarsih Istikoma',          'jabatan' => 'Anggota'],
                ['nama' => 'Istiqamah Fitri Riyowati',   'jabatan' => 'Anggota'],
                ['nama' => 'Ratna Kartika Sari',         'jabatan' => 'Anggota'],
                ['nama' => 'Nugroho Agus Rianto',        'jabatan' => 'Anggota'],
            ],
        ],
    ];

    $slugAktif = $param ?? 'dewan-konsultatif';
    $unsur ??= $dataUnsur[$slugAktif] ?? $dataUnsur['dewan-konsultatif'];

    // Struktur "panitia-kerja" punya 2 jenjang tambahan di atas Ketua, jadi
    // dibedakan dari layout lama (dewan-konsultatif: ketua/wakil/anggota).
    $isExtended = !empty($unsur['penanggung_jawab']);
    $isKosong = empty($unsur['penanggung_jawab']) && empty($unsur['ketua']) && empty($unsur['anggota']);

    // Dipakai untuk bikin id unik tiap kartu (buat modal profil & elemen yang
    // perlu direferensikan JS), supaya aman walau ada nama yang sama persis
    // (mis. "Nyoman Adhi Suryadnyana" muncul di 2 jabatan berbeda di atas).
    $slugNama = fn (string $teks, int $i) => \Illuminate\Support\Str::slug($teks) . '-' . $i;

    // Foto asli pimpinan/anggota (kalau ada). Dicocokkan otomatis dari nama
    // -> di-slug -> dicari filenya di public/assets/images/struktur/.
    // Contoh: "Isma Yatun" -> public/assets/images/struktur/isma-yatun.{jpg,jpeg,png,webp}
    // Sengaja dipisah dari public/assets/images/galeri/ (foto galeri momen di
    // beranda) dan TIDAK dinamai "pimpinan" biar tidak ketuker sama
    // public/assets/images/pemimpin.png (foto background hero, beda hal).
    // Kalau file untuk nama tsb belum ada, avatar tetap fallback ke ikon
    // placeholder seperti sebelumnya -- tidak perlu ubah kode tiap nambah foto.
    $fotoUntuk = function (string $nama) {
        $slug = \Illuminate\Support\Str::slug($nama);
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $rel = "assets/images/struktur/{$slug}.{$ext}";
            if (file_exists(public_path($rel))) {
                return asset($rel);
            }
        }
        return null;
    };
@endphp

<div class="spkn-struktur__panel">
    <div class="spkn-struktur__panel-head">
        <div>
            <h3 class="spkn-struktur__panel-title">Struktur {{ $unsur['judul'] }}</h3>
            <div class="spkn-struktur__legend">
                @if ($isExtended)
                    @if ($unsur['penanggung_jawab'] ?? null)
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--jawab"></i> Penanggung Jawab</span>
                    @endif
                    @if ($unsur['wakil_penanggung_jawab'] ?? null)
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--wakil-jawab"></i> Wakil Penanggung Jawab</span>
                    @endif
                    @if ($unsur['ketua'] ?? null)
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--ketua-pk"></i> Ketua</span>
                    @endif
                    @if (!empty($unsur['anggota']))
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--anggota-pk"></i> Anggota</span>
                    @endif
                    @if ($unsur['sekretaris'] ?? null)
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--sekretaris"></i> Sekretaris</span>
                    @endif
                @else
                    @if ($unsur['ketua'] ?? null)
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--ketua"></i> {{ $unsur['legend_ketua'] ?? 'Ketua' }}</span>
                    @endif
                    @if ($unsur['wakil'] ?? null)
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--wakil"></i> {{ $unsur['legend_wakil'] ?? 'Wakil Ketua' }}</span>
                    @endif
                    @if (!empty($unsur['anggota']))
                        <span><i class="spkn-struktur__dot spkn-struktur__dot--anggota"></i> Anggota</span>
                    @endif
                @endif
            </div>
        </div>

        <button type="button" class="spkn-struktur__download" data-struktur-download data-struktur-filename="struktur-{{ $slugAktif }}">
            <i class="bi bi-download" aria-hidden="true"></i> Unduh sebagai Gambar
        </button>
    </div>

    @if ($isKosong)
        <p class="spkn-struktur__empty">
            Bagan struktur untuk <strong>{{ $unsur['judul'] }}</strong> belum tersedia.
        </p>
    @else
        <div class="spkn-struktur__chart" data-struktur-chart>
            @if ($isExtended)
                {{-- Layout khusus Panitia Kerja: Penanggung Jawab -> Wakil Penanggung
                     Jawab -> Ketua, lalu Ketua bercabang ke Sekretaris & Anggota. --}}
                @if ($unsur['penanggung_jawab'] ?? null)
                    <div class="spkn-struktur__level">
                        <button
                            type="button"
                            class="spkn-struktur__node spkn-struktur__node--jawab"
                            data-bs-toggle="modal"
                            data-bs-target="#profil-{{ $slugNama($unsur['penanggung_jawab']['nama'], 0) }}"
                        >
                            <span class="spkn-struktur__avatar">
                                @if ($foto = $fotoUntuk($unsur['penanggung_jawab']['nama']))
                                    <img src="{{ $foto }}" alt="Foto {{ $unsur['penanggung_jawab']['nama'] }}" loading="lazy">
                                @else
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                @endif
                            </span>
                            <span class="spkn-struktur__node-jabatan">{{ $unsur['penanggung_jawab']['jabatan'] }}</span>
                            <span class="spkn-struktur__node-nama">{{ $unsur['penanggung_jawab']['nama'] }}</span>
                            <span class="spkn-struktur__node-hint">Klik untuk lihat profil</span>
                        </button>
                    </div>
                @endif

                @if ($unsur['wakil_penanggung_jawab'] ?? null)
                    <div class="spkn-struktur__connector-v" aria-hidden="true"></div>
                    <div class="spkn-struktur__level">
                        <button
                            type="button"
                            class="spkn-struktur__node spkn-struktur__node--wakil-jawab"
                            data-bs-toggle="modal"
                            data-bs-target="#profil-{{ $slugNama($unsur['wakil_penanggung_jawab']['nama'], 1) }}"
                        >
                            <span class="spkn-struktur__avatar">
                                @if ($foto = $fotoUntuk($unsur['wakil_penanggung_jawab']['nama']))
                                    <img src="{{ $foto }}" alt="Foto {{ $unsur['wakil_penanggung_jawab']['nama'] }}" loading="lazy">
                                @else
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                @endif
                            </span>
                            <span class="spkn-struktur__node-jabatan">{{ $unsur['wakil_penanggung_jawab']['jabatan'] }}</span>
                            <span class="spkn-struktur__node-nama">{{ $unsur['wakil_penanggung_jawab']['nama'] }}</span>
                            <span class="spkn-struktur__node-hint">Klik untuk lihat profil</span>
                        </button>
                    </div>
                @endif

                @if ($unsur['ketua'] ?? null)
                    <div class="spkn-struktur__connector-v" aria-hidden="true"></div>
                    <div class="spkn-struktur__level">
                        <button
                            type="button"
                            class="spkn-struktur__node spkn-struktur__node--ketua-pk"
                            data-bs-toggle="modal"
                            data-bs-target="#profil-{{ $slugNama($unsur['ketua']['nama'], 2) }}"
                        >
                            <span class="spkn-struktur__avatar">
                                @if ($foto = $fotoUntuk($unsur['ketua']['nama']))
                                    <img src="{{ $foto }}" alt="Foto {{ $unsur['ketua']['nama'] }}" loading="lazy">
                                @else
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                @endif
                            </span>
                            <span class="spkn-struktur__node-jabatan">{{ $unsur['ketua']['jabatan'] }}</span>
                            <span class="spkn-struktur__node-nama">{{ $unsur['ketua']['nama'] }}</span>
                            <span class="spkn-struktur__node-hint">Klik untuk lihat profil</span>
                        </button>
                    </div>
                @endif

                @if ($unsur['sekretaris'] ?? null)
                    <div class="spkn-struktur__fork" aria-hidden="false">
                        <div class="spkn-struktur__fork-branch">
                            <div class="spkn-struktur__connector-v spkn-struktur__connector-v--sm" aria-hidden="true"></div>
                            <button
                                type="button"
                                class="spkn-struktur__card spkn-struktur__card--sekretaris"
                                data-bs-toggle="modal"
                                data-bs-target="#profil-{{ $slugNama($unsur['sekretaris']['nama'], 3) }}"
                            >
                                <span class="spkn-struktur__avatar spkn-struktur__avatar--sm">
                                    @if ($foto = $fotoUntuk($unsur['sekretaris']['nama']))
                                        <img src="{{ $foto }}" alt="Foto {{ $unsur['sekretaris']['nama'] }}" loading="lazy">
                                    @else
                                        <i class="bi bi-person-fill" aria-hidden="true"></i>
                                    @endif
                                </span>
                                <span class="spkn-struktur__card-jabatan">{{ $unsur['sekretaris']['jabatan'] }}</span>
                                <span class="spkn-struktur__card-nama">{{ $unsur['sekretaris']['nama'] }}</span>
                            </button>
                        </div>
                    </div>
                @endif

                @if (!empty($unsur['anggota']))
                    <div class="spkn-struktur__connector-v" aria-hidden="true"></div>
                    <span class="spkn-struktur__branch-label">Anggota</span>

                    <div class="spkn-struktur__row spkn-struktur__row--wrap">
                        @foreach ($unsur['anggota'] as $i => $a)
                            <button
                                type="button"
                                class="spkn-struktur__card"
                                data-bs-toggle="modal"
                                data-bs-target="#profil-{{ $slugNama($a['nama'], $i + 4) }}"
                            >
                                <span class="spkn-struktur__avatar spkn-struktur__avatar--sm">
                                    @if ($foto = $fotoUntuk($a['nama']))
                                        <img src="{{ $foto }}" alt="Foto {{ $a['nama'] }}" loading="lazy">
                                    @else
                                        <i class="bi bi-person-fill" aria-hidden="true"></i>
                                    @endif
                                </span>
                                <span class="spkn-struktur__card-jabatan">{{ $a['jabatan'] }}</span>
                                <span class="spkn-struktur__card-nama">{{ $a['nama'] }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            @else
                {{-- Layout lama (Dewan Konsultatif, dst.): Ketua -> Wakil Ketua -> Anggota. --}}
                @if ($unsur['ketua'])
                    <div class="spkn-struktur__level">
                        <button
                            type="button"
                            class="spkn-struktur__node spkn-struktur__node--ketua"
                            data-bs-toggle="modal"
                            data-bs-target="#profil-{{ $slugNama($unsur['ketua']['nama'], 0) }}"
                        >
                            <span class="spkn-struktur__avatar">
                                @if ($foto = $fotoUntuk($unsur['ketua']['nama']))
                                    <img src="{{ $foto }}" alt="Foto {{ $unsur['ketua']['nama'] }}" loading="lazy">
                                @else
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                @endif
                            </span>
                            <span class="spkn-struktur__node-jabatan">{{ $unsur['ketua']['jabatan'] }}</span>
                            <span class="spkn-struktur__node-nama">{{ $unsur['ketua']['nama'] }}</span>
                            <span class="spkn-struktur__node-hint">Klik untuk lihat profil</span>
                        </button>
                    </div>
                @endif

                @if ($unsur['wakil'])
                    <div class="spkn-struktur__connector-v" aria-hidden="true"></div>
                    <div class="spkn-struktur__level">
                        <button
                            type="button"
                            class="spkn-struktur__node spkn-struktur__node--wakil"
                            data-bs-toggle="modal"
                            data-bs-target="#profil-{{ $slugNama($unsur['wakil']['nama'], 1) }}"
                        >
                            <span class="spkn-struktur__avatar">
                                @if ($foto = $fotoUntuk($unsur['wakil']['nama']))
                                    <img src="{{ $foto }}" alt="Foto {{ $unsur['wakil']['nama'] }}" loading="lazy">
                                @else
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                @endif
                            </span>
                            <span class="spkn-struktur__node-jabatan">{{ $unsur['wakil']['jabatan'] }}</span>
                            <span class="spkn-struktur__node-nama">{{ $unsur['wakil']['nama'] }}</span>
                            <span class="spkn-struktur__node-hint">Klik untuk lihat profil</span>
                        </button>
                    </div>
                @endif

                @if (!empty($unsur['anggota']))
                    <div class="spkn-struktur__connector-v" aria-hidden="true"></div>
                    <span class="spkn-struktur__branch-label">Anggota</span>

                    <div class="spkn-struktur__row">
                        @foreach ($unsur['anggota'] as $i => $a)
                            <button
                                type="button"
                                class="spkn-struktur__card"
                                data-bs-toggle="modal"
                                data-bs-target="#profil-{{ $slugNama($a['nama'], $i + 2) }}"
                            >
                                <span class="spkn-struktur__avatar spkn-struktur__avatar--sm">
                                    @if ($foto = $fotoUntuk($a['nama']))
                                        <img src="{{ $foto }}" alt="Foto {{ $a['nama'] }}" loading="lazy">
                                    @else
                                        <i class="bi bi-person-fill" aria-hidden="true"></i>
                                    @endif
                                </span>
                                <span class="spkn-struktur__card-jabatan">{{ $a['jabatan'] }}</span>
                                <span class="spkn-struktur__card-nama">{{ $a['nama'] }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>

        {{-- Modal profil ringkas — dipicu tombol/kartu di atas lewat Bootstrap modal,
             tidak perlu halaman/route terpisah per orang. --}}
        @php
            $semuaOrang = $isExtended
                ? [
                    $unsur['penanggung_jawab'] ?? null,
                    $unsur['wakil_penanggung_jawab'] ?? null,
                    $unsur['ketua'] ?? null,
                    $unsur['sekretaris'] ?? null,
                    ...($unsur['anggota'] ?? []),
                ]
                : [$unsur['ketua'] ?? null, $unsur['wakil'] ?? null, ...($unsur['anggota'] ?? [])];
        @endphp
        @foreach (array_filter($semuaOrang) as $i => $orang)
            <div class="modal fade" id="profil-{{ $slugNama($orang['nama'], $i) }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content spkn-struktur__modal">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body text-center pt-0">
                            <span class="spkn-struktur__avatar spkn-struktur__avatar--lg mx-auto">
                                @if ($foto = $fotoUntuk($orang['nama']))
                                    <img src="{{ $foto }}" alt="Foto {{ $orang['nama'] }}" loading="lazy">
                                @else
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                @endif
                            </span>
                            <span class="spkn-struktur__tag">{{ $orang['jabatan'] }}</span>
                            <h4 class="spkn-struktur__modal-nama">{{ $orang['nama'] }}</h4>
                            <p class="spkn-struktur__modal-note">
                                Profil lengkap (riwayat pendidikan &amp; karier) belum tersedia di halaman ini.
                                Untuk informasi resmi terverifikasi, kunjungi laman profil BPK RI.
                            </p>
                            <a
                                href="https://www.bpk.go.id/menu/profil_bpk"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="spkn-struktur__modal-link"
                            >
                                Lihat di bpk.go.id <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>