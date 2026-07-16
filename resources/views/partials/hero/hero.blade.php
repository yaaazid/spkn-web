<header
    class="spkn-hero"
    style="background-image: url('{{ asset('assets/images/pemimpin.png') }}');"
>
    <div class="spkn-hero__inner">
        <div class="spkn-hero__content">
            <h1 class="spkn-hero__title">
                Komite Standar Pemeriksaan Keuangan Negara <em>(SPKN)</em>
            </h1>
            <p class="spkn-hero__subtitle">
                Mewujudkan Standar Pemeriksaan yang Profesional, Transparan dan Berkualitas
            </p>
            <div class="spkn-hero__cta">
                <a href="{{ route('products.index') }}" class="spkn-btn-primary">
                    Lihat Standar SPKN
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>
                <a href="{{ route('about.history') }}" class="spkn-btn-outline-glass">
                    Pelajari Lebih Lanjut
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        @include('partials.hero.hero-stats')
    </div>
</header>