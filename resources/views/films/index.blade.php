{{-- resources/views/films/index.blade.php - TOP 10 GRID CARD --}}
@extends('layouts.app')
@section('title', 'Top 10 Film - CineMatch')
@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="section-title">Top 10 Film <span>Terpopuler</span></h1>
        <p class="text-muted mb-0">Berdasarkan rating pengguna dan relevansi waktu (timestamp)</p>
    </div>
    <span class="badge px-3 py-2"
          style="background:var(--accent);font-family:'Syne',sans-serif;font-size:0.85rem">
        <i class="bi bi-trophy-fill me-1"></i> Time-Decay Weighted
    </span>
</div>

{{-- Info Metode
<div class="p-3 rounded-3 mb-4 d-flex align-items-center gap-3"
     style="background:var(--bg-elevated);border:1px solid var(--border)">
    <i class="bi bi-info-circle" style="color:#ffd700;font-size:1.3rem;flex-shrink:0"></i>
    <p class="mb-0 text-muted small">
        Skor dihitung menggunakan <strong>time-decay weighted rating</strong>:
        <code style="background:var(--bg-dark);padding:2px 6px;border-radius:4px">
            w(t) = exp(-λ × Δt)
        </code>
        — Rating terbaru diberi bobot lebih besar (λ = 0.3).
        Hanya film dengan minimal 50 rating yang masuk perhitungan.
    </p>
</div> --}}

{{-- Grid Film --}}
@if(!empty($topFilms) && count($topFilms) > 0)
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
        @foreach($topFilms as $film)
        <div class="col">
            <div class="film-card position-relative">

                {{-- Badge Rank --}}
                <div class="position-absolute top-0 start-0 m-2"
                     style="z-index:2">
                    <span class="badge px-2 py-1"
                          style="background:{{ $loop->index < 3 ? 'var(--accent)' : 'rgba(0,0,0,0.7)' }};
                                 font-family:'Syne',sans-serif;font-size:0.8rem;
                                 backdrop-filter:blur(4px)">
                        @if($loop->index === 0) 🥇
                        @elseif($loop->index === 1) 🥈
                        @elseif($loop->index === 2) 🥉
                        @else #{{ $film['rank'] }}
                        @endif
                    </span>
                </div>

                {{-- Badge Skor --}}
                <div class="position-absolute top-0 end-0 m-2" style="z-index:2">
                    <span class="badge px-2 py-1"
                          style="background:rgba(0,0,0,0.7);
                                 backdrop-filter:blur(4px);
                                 font-size:0.7rem">
                        <i class="bi bi-lightning-fill text-warning"></i>
                        {{ number_format($film['skor'], 1) }}
                    </span>
                </div>

                {{-- Poster --}}
                @if(!empty($film['poster']))
                    <img src="{{ $film['poster'] }}"
                         alt="{{ $film['title'] }}"
                         class="poster">
                @else
                    <div class="poster-placeholder">
                        <i class="bi bi-film"></i>
                    </div>
                @endif

                {{-- Card Body --}}
                <div class="card-body">
                    <div class="card-title">{{ $film['title'] }}</div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">{{ $film['year'] ?? '-' }}</small>
                        <span class="rating-stars">
                            <i class="bi bi-star-fill" style="font-size:0.7rem"></i>
                            <small>{{ number_format($film['avg_rating'], 1) }}</small>
                        </span>
                    </div>

                    @if(!empty($film['genre']))
                        <div class="mt-2">
                            @foreach(array_slice(explode(', ', $film['genre']), 0, 2) as $g)
                                <span class="badge-genre me-1">{{ trim($g) }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="bi bi-people me-1"></i>
                            {{ number_format($film['total_rating']) }} rating
                        </small>
                    </div>

                    {{-- Tombol Detail --}}
                    @if(!empty($film['movie_id']))
                        <a href="{{ route('films.detail', $film['movie_id']) }}"
                           class="btn btn-accent btn-sm w-100 mt-2">
                            <i class="bi bi-play-fill me-1"></i> Detail
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tombol Rekomendasi --}}
    <div class="text-center mt-5 pt-3" style="border-top:1px solid var(--border)">
        <p class="text-muted mb-3">Ingin rekomendasi film yang dipersonalisasi?</p>
        <a href="{{ route('rekomendasi.index') }}" class="btn btn-accent btn-lg px-5">
            <i class="bi bi-stars me-2"></i> Dapatkan Rekomendasi Personal
        </a>
    </div>

@else
    <div class="text-center py-5">
        <i class="bi bi-film" style="font-size:4rem;color:var(--text-muted)"></i>
        <h4 class="mt-3" style="font-family:'Syne',sans-serif">Data belum tersedia</h4>
        <p class="text-muted">
            Pastikan file <code>top10_films.csv</code> sudah ada dan
            endpoint <code>/api/top-films</code> sudah ditambahkan di Flask API.
        </p>
    </div>
@endif

@endsection