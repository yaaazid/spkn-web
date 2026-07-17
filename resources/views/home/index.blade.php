@extends('layouts.app')

@section('title', 'Beranda — Komite SPKN BPK RI')

@section('content')
    @include('partials.hero.hero', ['stats' => $stats ?? null])
    @include('partials.home.unsur-komite')
    @include('partials.home.galeri-momen')
    @include('partials.home.proses-baku')
    @include('partials.home.berita-spkn')

    {{-- Section konten lain di bawah menyusul di sini, masing-masing sebagai
         partial sendiri (1 file = 1 section), contoh:
         @include('partials.home.latest-news')
         @include('partials.home.upcoming-agenda') --}}
@endsection