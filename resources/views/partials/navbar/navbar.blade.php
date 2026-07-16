{{--
    Navbar liquid-glass + off-canvas menu (meniru pola atescape.id).
    Data menu dari config/navigation.php.

    Struktur:
    - .spkn-navbar-root      -> pembungkus semua (pill navbar + backdrop + off-canvas),
                                 tempat class .is-menu-open ditoggle JS (navbar-scroll.js)
    - .spkn-navbar__chrome    -> cuma visual (kaca blur + efek sheen), overflow:hidden
                                 di sini AMAN karena tidak ada dropdown di dalamnya.
    - .spkn-navbar__content   -> isi asli (logo, menu, dropdown), TIDAK overflow:hidden
                                 supaya dropdown/flyout bisa tampil penuh, tidak kepotong.
    - .spkn-offcanvas-backdrop / .spkn-offcanvas -> panel menu penuh yang slide dari kiri
                                 saat tombol "Menu" diklik (mode ramping/mobile).
--}}
<div class="spkn-navbar-root" data-navbar-root>

    <div class="spkn-navbar-wrap">
        <nav class="spkn-navbar" aria-label="Navigasi utama">

            <div class="spkn-navbar__chrome glass-pill glass-sheen" aria-hidden="true"></div>

            <div class="spkn-navbar__content">
                <a href="{{ route('home') }}" class="spkn-brand">
                    <span class="spkn-brand__mark">SPKN</span>
                    <span class="spkn-brand__name">Komite SPKN</span>
                </a>

                <ul class="spkn-nav-list" data-nav-list>
                    @foreach (config('navigation.primary') as $item)
                        @if ($item['type'] === 'link')
                            <li>
                                <a
                                    href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                                    class="spkn-nav-link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}"
                                >
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @else
                            <li class="spkn-nav-item" data-dropdown>
                                <button
                                    type="button"
                                    class="spkn-nav-link"
                                    data-dropdown-trigger
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <span>{{ $item['label'] }}</span>
                                    <i class="bi bi-chevron-down spkn-nav-link__chevron" aria-hidden="true"></i>
                                </button>

                                <x-nav-dropdown-panel :menu="$item" />
                            </li>
                        @endif
                    @endforeach
                </ul>

                @include('partials.navbar.nav-actions')

                {{-- Tombol "Menu" — muncul saat navbar mode ramping (di-scroll di desktop,
                     atau selalu di mobile). Klik membuka off-canvas di bawah, ikon berubah
                     jadi silang (X) — perilaku & class-nya ditoggle navbar-scroll.js. --}}
                <button type="button" class="spkn-menu-toggle" data-menu-toggle aria-label="Buka menu" aria-expanded="false">
                    <span>Menu</span>
                    <i class="bi bi-list" data-menu-toggle-icon aria-hidden="true"></i>
                </button>
            </div>
        </nav>
    </div>

    {{-- Latar gelap di belakang off-canvas, klik buat nutup menu --}}
    <div class="spkn-offcanvas-backdrop" data-offcanvas-backdrop></div>

    {{-- Panel off-canvas: daftar menu penuh, dropdown jadi accordion --}}
    <aside class="spkn-offcanvas" data-offcanvas aria-label="Menu navigasi">
        <div class="spkn-offcanvas__brand">
            <span class="spkn-brand__mark">SPKN</span>
            <span>Komite SPKN</span>
        </div>

        <nav>
            <ul class="spkn-offcanvas__list">
                @foreach (config('navigation.primary') as $item)
                    @if ($item['type'] === 'link')
                        <li>
                            <a
                                href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                                class="spkn-offcanvas__link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @else
                        <li class="spkn-offcanvas__group" data-offcanvas-group>
                            <button type="button" class="spkn-offcanvas__link spkn-offcanvas__link--toggle" data-offcanvas-group-trigger>
                                <span>{{ $item['label'] }}</span>
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </button>

                            <div class="spkn-offcanvas__submenu" data-offcanvas-submenu>
                                @foreach ($item['columns'] as $column)
                                    @foreach ($column['items'] as $sub)
                                        <a
                                            href="{{ Route::has($sub['route'] ?? null) ? route($sub['route']) : '#' }}"
                                            class="spkn-offcanvas__sublink"
                                        >
                                            {{ $sub['label'] }}
                                        </a>
                                    @endforeach
                                @endforeach
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </aside>
</div>