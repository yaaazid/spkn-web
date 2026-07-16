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
            'ketua' => null,
            'wakil' => null,
            'anggota' => [],
        ],
        'sekretariat-spkn' => [
            'judul' => 'Sekretariat SPKN',
            'ketua' => null,
            'wakil' => null,
            'anggota' => [],
        ],
    ];

    $slugAktif = $param ?? 'dewan-konsultatif';
    $unsur ??= $dataUnsur[$slugAktif] ?? $dataUnsur['dewan-konsultatif'];

    // Dipakai untuk bikin id unik tiap kartu (buat modal profil & elemen yang
    // perlu direferensikan JS), supaya aman walau ada nama yang sama persis
    // (mis. "Nyoman Adhi Suryadnyana" muncul di 2 jabatan berbeda di atas).
    $slugNama = fn (string $teks, int $i) => \Illuminate\Support\Str::slug($teks) . '-' . $i;
@endphp

<div class="spkn-struktur__panel">
    <div class="spkn-struktur__panel-head">
        <div>
            <h3 class="spkn-struktur__panel-title">Struktur {{ $unsur['judul'] }}</h3>
            <div class="spkn-struktur__legend">
                <span><i class="spkn-struktur__dot spkn-struktur__dot--ketua"></i> Ketua</span>
                <span><i class="spkn-struktur__dot spkn-struktur__dot--wakil"></i> Wakil Ketua</span>
                <span><i class="spkn-struktur__dot spkn-struktur__dot--anggota"></i> Anggota</span>
            </div>
        </div>

        <button type="button" class="spkn-struktur__download" data-struktur-download data-struktur-filename="struktur-{{ $slugAktif }}">
            <i class="bi bi-download" aria-hidden="true"></i> Unduh sebagai Gambar
        </button>
    </div>

    @if (!$unsur['ketua'] && empty($unsur['anggota']))
        <p class="spkn-struktur__empty">
            Bagan struktur untuk <strong>{{ $unsur['judul'] }}</strong> belum tersedia.
        </p>
    @else
        <div class="spkn-struktur__chart" data-struktur-chart>
            @if ($unsur['ketua'])
                <div class="spkn-struktur__level">
                    <button
                        type="button"
                        class="spkn-struktur__node spkn-struktur__node--ketua"
                        data-bs-toggle="modal"
                        data-bs-target="#profil-{{ $slugNama($unsur['ketua']['nama'], 0) }}"
                    >
                        <span class="spkn-struktur__avatar"><i class="bi bi-person-fill" aria-hidden="true"></i></span>
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
                        <span class="spkn-struktur__avatar"><i class="bi bi-person-fill" aria-hidden="true"></i></span>
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
                            <span class="spkn-struktur__avatar spkn-struktur__avatar--sm"><i class="bi bi-person-fill" aria-hidden="true"></i></span>
                            <span class="spkn-struktur__card-jabatan">{{ $a['jabatan'] }}</span>
                            <span class="spkn-struktur__card-nama">{{ $a['nama'] }}</span>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Modal profil ringkas — dipicu tombol/kartu di atas lewat Bootstrap modal,
             tidak perlu halaman/route terpisah per orang. --}}
        @foreach (array_filter([$unsur['ketua'], $unsur['wakil'], ...$unsur['anggota']]) as $i => $orang)
            <div class="modal fade" id="profil-{{ $slugNama($orang['nama'], $i) }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content spkn-struktur__modal">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body text-center pt-0">
                            <span class="spkn-struktur__avatar spkn-struktur__avatar--lg mx-auto">
                                <i class="bi bi-person-fill" aria-hidden="true"></i>
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
</div>s