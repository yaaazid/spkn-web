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

    @include('partials.committee.buku-cetakan')

    @include('partials.committee.latar-belakang')
    @include('partials.committee.arsip-keputusan')

@endsection