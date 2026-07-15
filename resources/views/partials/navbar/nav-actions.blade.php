<div class="spkn-nav-actions">
    <button type="button" class="spkn-icon-btn" aria-label="Cari">
        <i class="bi bi-search" aria-hidden="true"></i>
    </button>

    @auth
        <a href="{{ route('dashboard') }}" class="spkn-btn-login">
            <i class="bi bi-person-circle" aria-hidden="true"></i>
            <span class="spkn-btn-login-label">{{ auth()->user()->name }}</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="spkn-btn-login">
            <i class="bi bi-person-fill" aria-hidden="true"></i>
            <span class="spkn-btn-login-label">Login</span>
        </a>
    @endauth
</div>