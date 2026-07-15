<aside class="p-3" style="width: 260px; min-height: 100vh; background: var(--spkn-navy-800); color: #fff;">
    <div class="fw-bold mb-4">Admin — Komite SPKN</div>
    <ul class="list-unstyled d-flex flex-column gap-1">
        <li><a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-block py-2">Dashboard</a></li>
        <li><a href="{{ route('admin.menu.index') }}" class="text-white text-decoration-none d-block py-2">Menu</a></li>
        <li><a href="{{ route('admin.anggota-komite.index') }}" class="text-white text-decoration-none d-block py-2">Anggota Komite</a></li>
        <li><a href="{{ route('admin.dokumen.index') }}" class="text-white text-decoration-none d-block py-2">Dokumen</a></li>
        <li><a href="{{ route('admin.forum.index') }}" class="text-white text-decoration-none d-block py-2">Forum</a></li>
        <li><a href="{{ route('admin.agenda.index') }}" class="text-white text-decoration-none d-block py-2">Agenda</a></li>
        <li><a href="{{ route('admin.revisi-spkn.index') }}" class="text-white text-decoration-none d-block py-2">Revisi SPKN</a></li>
        <li><a href="{{ route('admin.statistik.index') }}" class="text-white text-decoration-none d-block py-2">Statistik</a></li>
    </ul>
</aside>