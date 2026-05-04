@extends('layouts.app')
@section('title', "Rekomendasi untuk User {$userId} - CineMatch")
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="section-title">Rekomendasi <span>Film</span></h1>
        <p class="text-muted mb-0">User ID: <strong>{{ $userId }}</strong> · K={{ $k }} · Top {{ $topN }}</p>
    </div>
    <a href="{{ route('rekomendasi.index') }}" class="btn btn-outline-accent">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

@if($status !== 'ok' || empty($rekomendasi))
    <div class="text-center py-5">
        <i class="bi bi-exclamation-circle" style="font-size:4rem;color:var(--text-muted)"></i>
        <h4 class="mt-3" style="font-family:'Syne',sans-serif">Tidak Ada Rekomendasi</h4>
        <p class="text-muted">{{ $pesan ?: 'User perlu memberi rating lebih banyak film terlebih dahulu.' }}</p>
        <a href="{{ route('rekomendasi.index') }}" class="btn btn-accent mt-2">Coba User Lain</a>
    </div>
@else
    <div class="row g-3">
        @foreach($rekomendasi as $film)
        <div class="col-md-6 col-lg-4">
            <div class="film-card d-flex" style="height:auto">
                {{-- Rank Badge --}}
                <div class="d-flex align-items-center justify-content-center p-3"
                     style="background:var(--bg-elevated);min-width:50px">
                    <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;color:var(--accent)">
                        #{{ $film['rank'] }}
                    </span>
                </div>

                {{-- Info --}}
                <div class="p-3 flex-grow-1">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.9rem">
                        {{ $film['title'] ?? 'Film #' . $film['movie_encoded'] }}
                    </div>

                    @if(!empty($film['genre']))
                        <div class="mt-1">
                            @foreach(array_slice(explode('|', $film['genre']), 0, 2) as $g)
                                <span class="badge-genre me-1">{{ $g }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">{{ $film['year'] ?? '' }}</small>
                        <span class="rating-stars">
                            <i class="bi bi-star-fill" style="font-size:0.7rem"></i>
                            <small><strong>{{ number_format($film['skor_prediksi'], 2) }}</strong></small>
                        </span>
                    </div>
                </div>

                {{-- Link Detail --}}
                @if(!empty($film['id']))
                <div class="d-flex align-items-center pe-3">
                    <a href="{{ route('films.detail', $film['id']) }}"
                       class="btn btn-outline-accent btn-sm">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection