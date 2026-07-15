{{--
    Navbar liquid-glass, sticky di atas hero. Data menu dari config/navigation.php.

    Struktur sengaja dipecah jadi 2 lapisan:
    - .spkn-navbar__chrome  -> cuma visual (kaca blur + efek sheen), overflow:hidden
                               di sini AMAN karena tidak ada dropdown di dalamnya.
    - .spkn-navbar__content -> isi asli (logo, menu, dropdown), TIDAK overflow:hidden
                               supaya dropdown/flyout bisa tampil penuh, tidak kepotong.
--}}
<div class="spkn-navbar-wrap">
    <nav class="spkn-navbar" aria-label="Navigasi utama">

        <div class="spkn-navbar__chrome glass-pill glass-sheen" aria-hidden="true"></div>

        <div class="spkn-navbar__content">
            <a href="{{ route('home') }}" class="spkn-brand">
                <span class="spkn-brand__mark">SPKN</span>
                <span class="spkn-brand__name">Komite SPKN</span>
            </a>

            <ul class="spkn-nav-list">
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

            <button type="button" class="spkn-nav-toggle spkn-icon-btn" aria-label="Buka menu">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
        </div>
    </nav>
</div>