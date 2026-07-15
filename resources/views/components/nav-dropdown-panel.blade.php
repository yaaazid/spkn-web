{{--
    Komponen: <x-nav-dropdown-panel :menu="$menuItem" />
    Merender satu panel dropdown (mega-menu) berdasarkan definisi di config/navigation.php.
    Mendukung flyout tingkat dua lewat key 'children' pada tiap item.
--}}
@props(['menu'])

<div class="spkn-dropdown glass-panel" data-dropdown-panel>
    <div class="d-flex" style="gap: 12px;">
        @foreach ($menu['columns'] as $column)
            <ul class="spkn-dropdown__list" style="min-width: 240px;">
                @foreach ($column['items'] as $item)
                    @php
                        $hasChildren = isset($item['children']);
                        $flyoutItems = $hasChildren ? config('navigation.' . $item['children'], []) : [];
                    @endphp

                    <li class="spkn-dropdown__item" @if ($hasChildren) data-flyout @endif>
                        <a
                            href="{{ Route::has($item['route'] ?? null) ? route($item['route']) : '#' }}"
                            class="spkn-dropdown__link"
                            @if ($hasChildren) data-flyout-trigger @endif
                        >
                            <span>{{ $item['label'] }}</span>
                            @if ($hasChildren)
                                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                            @endif
                        </a>

                        @if ($hasChildren)
                            <x-nav-flyout-panel :items="$flyoutItems" />
                        @endif
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>
</div>