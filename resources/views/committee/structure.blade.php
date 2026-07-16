@extends('layouts.app')

@section('title', 'Struktur Komite SPKN — Komite SPKN BPK RI')

@php
    // Halaman landing tanpa param spesifik di URL. Defaultnya menampilkan
    // unsur "Dewan Konsultatif". Markup hero & chart-nya sama persis dengan
    // committee/structure-show.blade.php lewat partial bersama supaya tidak
    // dobel kode -- kalau butuh ubah tampilan, cukup edit satu partial itu.
    $param = 'dewan-konsultatif';
@endphp

@section('content')
    @include('partials.committee.struktur-hero', ['param' => $param])

    <section class="spkn-struktur">
        <div class="spkn-struktur__inner">
            @include('partials.committee.struktur-chart', ['param' => $param])
        </div>
    </section>
@endsection