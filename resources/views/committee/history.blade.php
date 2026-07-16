@extends('layouts.app')

@section('title', 'Sejarah Pembentukan Komite SPKN — Komite SPKN BPK RI')

@section('content')

    <x-page-header
        badge="Tentang Kami"
        title="Sejarah Pembentukan Komite SPKN"
        description="Menelusuri perjalanan pembentukan Komite Standar Pemeriksaan Keuangan Negara (SPKN) sejak pertama kali dibentuk hingga rangkaian keputusan yang menyertainya."
    >
        <div class="spkn-page-header__stats">
            <x-stat-card value="2010" label="Komite pertama dibentuk" />
            <x-stat-card value="14" label="Keputusan BPK diterbitkan" />
            <x-stat-card value="3" label="Unsur komite awal" />
        </div>
    </x-page-header>

    {{--
        TODO: konten naratif sejarah (mis. linimasa per-keputusan BPK, tokoh,
        milestone) menyusul di sini setelah materinya tersedia. Sengaja tidak
        diisi draf otomatis supaya tidak ada fakta sejarah/legal yang keliru
        soal Komite SPKN — cukup sambungkan dari sumber resmi BPK.
    --}}
    <section class="container py-5">
        <p class="text-muted">Linimasa sejarah lengkap akan ditambahkan di sini.</p>
    </section>

@endsection