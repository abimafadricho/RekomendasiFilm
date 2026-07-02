@extends('layouts.app')
@section('title', 'Dashboard Admin - CineMatch')
@section('content')

<div class="mb-4">
    <h1 class="section-title">Dashboard <span>Admin</span></h1>
    <p class="text-muted">Kelola sistem rekomendasi film</p>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['icon'=>'film',       'label'=>'Total Film',   'value'=>number_format($totalFilm),   'color'=>'#e63946'],
        ['icon'=>'people',     'label'=>'Total User',   'value'=>number_format($totalUser),   'color'=>'#2196f3'],
        ['icon'=>'star-fill',  'label'=>'Total Rating', 'value'=>number_format($totalRating), 'color'=>'#ffd700'],
        ['icon'=>'activity',   'label'=>'Status API',   'value'=>($apiStatus['status']??'?') === 'ok' ? '✅ Online' : '❌ Offline', 'color'=>'#4caf50'],
    ];
    @endphp

    @foreach($stats as $stat)
    <div class="col-6 col-md-3">
        <div class="p-4 rounded-3 text-center" style="background:var(--bg-card);border:1px solid var(--border)">
            <i class="bi bi-{{ $stat['icon'] }}" style="font-size:2rem;color:{{ $stat['color'] }}"></i>
            <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;margin-top:0.5rem;color:#ffffff !important">
                {{ $stat['value'] }}
            </div>
            <small class="text-muted">{{ $stat['label'] }}</small>
        </div>
    </div>
    @endforeach
</div>

{{-- Info Model --}}
@if(isset($apiStatus['n_users']))
<div class="p-4 rounded-3 mb-4" style="background:var(--bg-card);border:1px solid var(--border)">
    <h5 style="font-family:'Syne',sans-serif">
        <i class="bi bi-cpu me-2" style="color:var(--accent)"></i>Info Model IBCF
    </h5>
    <div class="row g-3 mt-1">
        <div class="col-md-3">
            <small class="text-muted d-block">Total User Training</small>
            <strong>{{ number_format($apiStatus['n_users'] ?? 0) }}</strong>
        </div>
        <div class="col-md-3">
            <small  class="text-muted d-block">Total Film Training</small>
            <strong>{{ number_format($apiStatus['n_movies'] ?? 0) }}</strong>
        </div>
        <div class="col-md-3">
            <small class="text-muted d-block">Model Loaded</small>
            <strong>{{ ($apiStatus['model_loaded'] ?? false) ? '✅ Ya' : '❌ Tidak' }}</strong>
        </div>
        <div class="col-md-3">
            <small class="text-muted d-block">Matrix Loaded</small>
            <strong>{{ ($apiStatus['matrix_loaded'] ?? false) ? '✅ Ya' : '❌ Tidak' }}</strong>
        </div>
    </div>
</div>
@endif

{{-- Quick Links --}}
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.films') }}" class="text-decoration-none">
            <div class="p-4 rounded-3" style="background:var(--bg-elevated);border:1px solid var(--border)">
                <i class="bi bi-collection-play" style="font-size:2rem;color:var(--accent)"></i>
                <h6 class="mt-2" style="font-family:'Syne',sans-serif">Kelola Film</h6>
                <small class="text-muted">Tambah, edit, hapus data film</small>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('rekomendasi.index') }}" class="text-decoration-none">
            <div class="p-4 rounded-3" style="background:var(--bg-elevated);border:1px solid var(--border)">
                <i class="bi bi-stars" style="font-size:2rem;color:#ffd700"></i>
                <h6 class="mt-2" style="font-family:'Syne',sans-serif">Test Rekomendasi</h6>
                <small class="text-muted">Coba sistem rekomendasi</small>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('films.index') }}" class="text-decoration-none">
            <div class="p-4 rounded-3" style="background:var(--bg-elevated);border:1px solid var(--border)">
                <i class="bi bi-eye" style="font-size:2rem;color:#2196f3"></i>
                <h6 class="mt-2" style="font-family:'Syne',sans-serif">Lihat Website</h6>
                <small class="text-muted">Tampilan halaman publik</small>
            </div>
        </a>
    </div>
</div>

@endsection