@extends('layouts.app')

@php
    $judulUnsur = match ($param ?? null) {
        'dewan-konsultatif' => 'Dewan Konsultatif',
        'panitia-kerja'     => 'Panitia Kerja',
        'sekretariat-spkn'  => 'Sekretariat SPKN',
        default             => 'Komite SPKN',
    };
@endphp

@section('title', "Struktur {$judulUnsur} — Komite SPKN BPK RI")

@section('content')
    @include('partials.committee.struktur-hero', ['param' => $param])

    <section class="spkn-struktur">
        <div class="spkn-struktur__inner">
            @include('partials.committee.struktur-chart', ['param' => $param])
        </div>
    </section>
@endsection