{{--
    Section "Rincian Tugas" halaman Tugas (Tentang Kami > Tugas), tampil di
    bawah tugas-hero.blade.php. Badge "RINCIAN TUGAS" sesuai referensi desain.

    Pola sama dengan partials/committee & partials/home lain: 1 file = 1
    section, data statis di $rincianTugas BISA disuplai dari controller kalau
    nanti mau dibikin dinamis dari admin.

    Icon & warna aksen tiap unsur SENGAJA disamakan dengan
    partials/home/unsur-komite.blade.php (Dewan Konsultatif = indigo/bi-building,
    Panitia Kerja = gold/bi-award, Tim Teknis = teal/bi-tools,
    Sekretariat = purple/bi-folder-fill) supaya konsisten satu unsur = satu
    warna & ikon di seluruh situs.

    CATATAN ISI: baru unsur "Dewan Konsultatif" yang punya rincian tugas &
    fungsi resmi (4 poin, sesuai referensi desain). Tugas & fungsi Panitia
    Kerja, Tim Teknis, dan Sekretariat BELUM ADA SUMBERNYA -- jangan diisi
    karangan sendiri karena ini menyangkut kewenangan resmi tiap unsur
    komite. Tab-nya sudah jalan (bisa diklik), tapi isinya masih placeholder
    "menyusul" sampai datanya didapat. Begitu ada rincian resminya, tinggal
    isi array 'tasks' di bawah.
--}}
@php
    $rincianTugas ??= [
        'dewan-konsultatif' => [
            'icon'   => 'bi-building',
            'accent' => 'indigo',
            'title'  => 'Dewan Konsultatif',
            'desc'   => 'Unsur pengarah Komite SPKN.',
            'tasks'  => [
                'Memberikan pengarahan kepada Panitia Kerja terkait dengan pemantauan dan pengembangan SPKN.',
                'Memantau, mereview, dan membahas hasil pemantauan dan pengembangan SPKN hasil Panitia Kerja.',
                'Memantau, mereview, dan membahas hasil pemantauan dan pengembangan SPKN hasil Panitia Kerja.',
                'Menyetujui hasil pemantauan dan pengembangan SPKN yang dilakukan oleh Panitia Kerja.',
            ],
        ],
        'panitia-kerja' => [
            'icon'   => 'bi-award',
            'accent' => 'gold',
            'title'  => 'Panitia Kerja',
            'desc'   => 'Unsur pelaksana kegiatan komite.',
            'tasks'  => [],
        ],
        'tim-teknis' => [
            'icon'   => 'bi-tools',
            'accent' => 'teal',
            'title'  => 'Tim Teknis',
            'desc'   => 'Unsur pembantu panitia kerja.',
            'tasks'  => [],
        ],
        'sekretariat' => [
            'icon'   => 'bi-folder-fill',
            'accent' => 'purple',
            'title'  => 'Sekretariat',
            'desc'   => 'Unsur pendukung panitia kerja dan tim teknis.',
            'tasks'  => [],
        ],
    ];
@endphp

<section class="spkn-rincian-tugas">
    <div class="spkn-rincian-tugas__inner">
        <span class="spkn-rincian-tugas__badge reveal">
            <i class="bi bi-list-check" aria-hidden="true"></i>
            Rincian Tugas
        </span>

        <h2 class="spkn-rincian-tugas__title reveal">Pilih unsur untuk melihat tugasnya</h2>

        <p class="spkn-rincian-tugas__desc reveal">
            Klik salah satu unsur di bawah untuk membaca daftar tugas dan fungsinya
            secara lengkap.
        </p>

        <div class="spkn-rincian-tugas__tabs reveal" role="tablist" data-rincian-tugas>
            @foreach ($rincianTugas as $key => $unsur)
                <button
                    type="button"
                    class="spkn-rincian-tugas__tab{{ $loop->first ? ' is-active' : '' }}"
                    data-rincian-tugas-tab
                    data-target="{{ $key }}"
                    role="tab"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="rincian-tugas-{{ $key }}"
                >
                    <i class="bi {{ $unsur['icon'] }}" aria-hidden="true"></i>
                    {{ $unsur['title'] }}
                </button>
            @endforeach
        </div>

        @foreach ($rincianTugas as $key => $unsur)
            <div
                id="rincian-tugas-{{ $key }}"
                class="spkn-rincian-tugas__panel reveal{{ $loop->first ? ' is-active' : '' }}"
                data-rincian-tugas-panel="{{ $key }}"
                role="tabpanel"
                @if (! $loop->first) hidden @endif
            >
                <div class="spkn-rincian-tugas__head">
                    <div class="spkn-rincian-tugas__icon spkn-rincian-tugas__icon--{{ $unsur['accent'] }}">
                        <i class="bi {{ $unsur['icon'] }}" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="spkn-rincian-tugas__head-title">{{ $unsur['title'] }}</h3>
                        <p class="spkn-rincian-tugas__head-desc">{{ $unsur['desc'] }}</p>
                    </div>
                </div>

                <div class="spkn-rincian-tugas__list">
                    @forelse ($unsur['tasks'] as $task)
                        <div class="spkn-rincian-tugas__item">
                            <span class="spkn-rincian-tugas__num">{{ sprintf('%02d', $loop->iteration) }}</span>
                            <p class="spkn-rincian-tugas__item-text">{{ $task }}</p>
                        </div>
                    @empty
                        <div class="spkn-rincian-tugas__item spkn-rincian-tugas__item--empty">
                            <i class="bi bi-hourglass-split" aria-hidden="true"></i>
                            <p class="spkn-rincian-tugas__item-text">
                                Rincian tugas &amp; fungsi {{ $unsur['title'] }} masih disiapkan, menyusul segera.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</section>
