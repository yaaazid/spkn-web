<?php

/**
 * Sumber tunggal (single source of truth) untuk struktur menu navbar.
 *
 * Kenapa dipisah ke config, bukan ditulis langsung di Blade?
 * - Navbar desktop, offcanvas mobile, dan (nanti) sitemap/footer bisa pakai
 *   data yang sama tanpa duplikasi.
 * - Tim lain yang menambah menu baru cukup edit file ini, tidak perlu
 *   menyentuh file Blade/CSS sehingga kecil kemungkinan merge conflict.
 *
 * Struktur tiap item:
 *   label     : teks yang tampil
 *   route     : nama route Laravel (dipakai dengan route(), fallback '#' jika belum ada)
 *   type      : 'link' (langsung) atau 'dropdown' (punya submenu)
 *   key       : slug unik untuk keperluan JS (data-dropdown-key)
 *   columns   : array kolom untuk mega-menu, tiap kolom berisi 'items'
 *   children  : (opsional, di dalam item) submenu flyout tingkat dua
 */

return [

    'primary' => [
        [
            'label' => 'Beranda',
            'route' => 'home',
            'type'  => 'link',
        ],

        [
            'label' => 'Tentang Kami',
            'type'  => 'dropdown',
            'key'   => 'tentang-kami',
            'columns' => [
                [
                    'items' => [
                        [
                            'label' => 'Sejarah',
                            'route' => 'about.history',
                        ],
                        [
                            'label'    => 'Struktur Komite SPKN',
                            'route'    => 'about.structure',
                            'children' => 'committee_structure', // merujuk ke key di bawah
                        ],
                        [
                            'label'    => 'Struktur Tim Teknis',
                            'route'    => 'about.technical-team',
                            'children' => 'technical_teams', // merujuk ke key di bawah
                        ],
                        [
                            'label' => 'Tugas',
                            'route' => 'about.tasks',
                        ],
                    ],
                ],
            ],
        ],

        [
            'label' => 'Proses Baku',
            'type'  => 'dropdown',
            'key'   => 'proses-baku',
            'columns' => [
                [
                    'items' => [
                        ['label' => 'Tahapan Penyusunan Standar', 'route' => 'process.stages'],
                        ['label' => 'Konsultasi Publik',          'route' => 'process.public-consultation'],
                        ['label' => 'Pengesahan Standar',          'route' => 'process.ratification'],
                    ],
                ],
            ],
        ],

        [
            'label' => 'Produk dan Referensi',
            'type'  => 'dropdown',
            'key'   => 'produk-referensi',
            'columns' => [
                [
                    'items' => [
                        ['label' => 'Produk',                 'route' => 'products.index'],
                        ['label' => 'IFPP',                   'route' => 'products.ifpp'],
                        ['label' => 'ISA',                    'route' => 'products.isa'],
                        ['label' => 'SPAP',                   'route' => 'products.spap'],
                        ['label' => 'Standar Audit Lain',      'route' => 'products.other-audit'],
                        ['label' => 'Standar Penugasan Lain',  'route' => 'products.other-assignment'],
                        ['label' => 'Perpustakaan',            'route' => 'library.index'],
                    ],
                ],
            ],
        ],

        [
            'label' => 'Berita',
            'route' => 'news.index',
            'type'  => 'link',
        ],
        [
            'label' => 'Forum',
            'route' => 'forum.index',
            'type'  => 'link',
        ],
        [
            'label' => 'Agenda',
            'route' => 'agenda.index',
            'type'  => 'link',
        ],
    ],

    /**
     * Submenu flyout tingkat dua untuk "Struktur Komite SPKN".
     */
    'committee_structure' => [
        ['label' => 'Dewan Konsultatif', 'route' => 'committee-structure.show', 'param' => 'dewan-konsultatif'],
        ['label' => 'Panitia Kerja',      'route' => 'committee-structure.show', 'param' => 'panitia-kerja'],
        ['label' => 'Sekretariat SPKN',   'route' => 'committee-structure.show', 'param' => 'sekretariat-spkn'],
    ],

    /**
     * Submenu flyout tingkat dua, dipisah dari 'primary' supaya daftar tim
     * teknis yang panjang tidak membuat array utama sulit dibaca/di-diff.
     */
    'technical_teams' => [
        ['label' => 'Tim Teknis Bidang Pengendalian dan Harmonisasi Pernyataan Profesional BPK', 'route' => 'technical-team.show', 'param' => 'pengendalian-harmonisasi'],
        ['label' => 'Tim Teknis Bidang Prinsip BPK dan Standar Persyaratan Organisasi',           'route' => 'technical-team.show', 'param' => 'prinsip-organisasi'],
        ['label' => 'Tim Teknis Bidang Standar Umum, Standar Pelaksanaan, dan Standar Pelaporan', 'route' => 'technical-team.show', 'param' => 'umum-pelaksanaan-pelaporan'],
        ['label' => 'Tim Teknis Bidang Standar Pemeriksaan Keuangan',                             'route' => 'technical-team.show', 'param' => 'pemeriksaan-keuangan'],
        ['label' => 'Tim Teknis Bidang Standar Pemeriksaan Kinerja',                              'route' => 'technical-team.show', 'param' => 'pemeriksaan-kinerja'],
        ['label' => 'Tim Teknis Bidang Standar Pemeriksaan Dengan Tujuan Tertentu',                'route' => 'technical-team.show', 'param' => 'tujuan-tertentu'],
        ['label' => 'Tim Teknis Bidang Standar Penugasan Lain',                                   'route' => 'technical-team.show', 'param' => 'penugasan-lain'],
        ['label' => 'Tim Teknis Bidang Standar Kompetensi',                                       'route' => 'technical-team.show', 'param' => 'kompetensi'],
    ],

];