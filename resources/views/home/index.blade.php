@extends('layouts.app')

@section('title', 'Beranda — Komite SPKN BPK RI')

@section('content')
    @include('partials.hero.hero', ['stats' => $stats ?? null])

    {{-- Section konten lain di bawah hero menyusul di sini,
         masing-masing sebaiknya jadi partial sendiri, contoh:
         @include('partials.home.about-preview')
         @include('partials.home.latest-news') --}}
@endsection