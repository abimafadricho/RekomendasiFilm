@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="section-title">Film <span>Rekomendasi</span></h1>
            <p class="text-muted mb-0">
                Film posisi #11 ke bawah — berpotensi masuk Top-10 jika mendapat lebih banyak rating
            </p>
        </div>
        <span class="badge px-3 py-2"
              style="background:var(--accent);font-family:'Syne',sans-serif;font-size:0.85rem">
            <i class="bi bi-graph-up-arrow me-1"></i> Kandidat Top-10
        </span>
    </div>

    {{-- Toggle Region --}}
    <div class="mb-4 d-flex align-items-center gap-3 flex-wrap">

    <div class="region-toggle">
        <a href="{{ route('films.index') }}?region=global"
           class="region-toggle__option {{ $region === 'global' ? 'is-active' : '' }}">
            <span class="region-toggle__flag">🌍</span> Global
        </a>
        <a href="{{ route('films.index') }}?region=indonesia"
           class="region-toggle__option {{ $region === 'indonesia' ? 'is-active' : '' }}">
            <span class="region-toggle__flag">🇮🇩</span> Indonesia
        </a>
    </div>
</div>

<style>
    .region-toggle {
        display: inline-flex;
        background: var(--bg-elevated);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 4px;
        gap: 4px;
    }

    .region-toggle__option {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 18px;
        border-radius: 999px;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .region-toggle__option:hover:not(.is-active) {
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.05);
    }

    .region-toggle__option.is-active {
        background: linear-gradient(135deg, var(--accent), var(--accent-soft));
        color: #fff;
        box-shadow: 0 2px 10px rgba(230, 57, 70, 0.4);
    }

    .region-toggle__flag {
        font-size: 1rem;
        line-height: 1;
    }
</style>

    {{-- Grid Film --}}
    @if(count($films) > 0)
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
            @foreach($films as $film)
            <div class="col">
                @if(!empty($film['movie_id']))
                    <a href="{{ route('films.detail', $film['movie_id']) }}"
                       class="film-card position-relative d-block text-decoration-none text-reset">
                @else
                    <div class="film-card position-relative">
                @endif

                    {{-- Badge Rank --}}
                    <div class="position-absolute"
                         style="top:8px;left:8px;z-index:2;background:var(--accent);color:#fff;font-family:'Syne',sans-serif;font-weight:700;font-size:0.75rem;padding:2px 8px;border-radius:20px">
                        #{{ $film['rank'] }}
                    </div>

                    {{-- Poster --}}
                    <div class="poster-wrapper">
                        @if(!empty($film['poster']))
                            <img src="{{ $film['poster'] }}"
                                 alt="{{ $film['title'] }}"
                                 class="poster">
                        @else
                            <div class="poster-placeholder">
                                <i class="bi bi-film"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">
                        <div class="card-title">{{ $film['title'] ?? 'Film #'.$film['movie_id'] }}</div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small style="color:#ffffff">{{ $film['year'] ?? '-' }}</small>
                            <span class="rating-stars">
                                <i class="bi bi-star-fill" style="font-size:0.7rem"></i>
                                <small style="color:#ffffff">{{ number_format($film['avg_rating'] ?? 0, 1) }}</small>
                            </span>
                        </div>

                        {{-- Skor Time-Decay --}}
                        <div class="mt-2">
                            <small style="color:var(--accent);font-size:0.72rem;font-weight:600">
                                <i class="bi bi-clock-history me-1"></i>
                                Skor: {{ number_format($film['skor'] ?? 0, 4) }}
                            </small>
                        </div>

                        {{-- Tombol Lihat Detail --}}
                        @if(!empty($film['movie_id']))
                            <span class="btn btn-accent btn-sm w-100 mt-2 d-block text-center">
                                <i class="bi bi-play-fill me-1"></i> Lihat Detail
                            </span>
                        @endif
                    </div>

                @if(!empty($film['movie_id']))
                    </a>
                @else
                    </div>
                @endif
            </div>
            @endforeach
        </div>

    @else
        <div class="text-center py-5" style="color:var(--text-muted)">
            <i class="bi bi-film d-block mb-3" style="font-size:3rem;opacity:0.3"></i>
            <p>Data belum tersedia. Pastikan server Flask berjalan.</p>
        </div>
    @endif

</div>
@endsection