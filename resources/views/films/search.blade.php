@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="section-title">Cari <span>Film</span></h1>
        <p class="text-muted mb-0">Temukan film dari seluruh database</p>
    </div>

    {{-- Form Search --}}
    <form method="GET" action="{{ route('films.search') }}" class="mb-4">
        <div class="d-flex gap-2 flex-wrap">

            {{-- Input pencarian --}}
            <div class="flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text"
                          style="background:var(--bg-elevated);border:1px solid var(--border);border-right:none;color:var(--text-muted)">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text"
                           name="q"
                           class="form-control"
                           placeholder="Cari judul film... (contoh: Toy Story, Laskar Pelangi)"
                           value="{{ $query ?? '' }}"
                           style="background:var(--bg-elevated);border:1px solid var(--border);border-left:none;color:var(--text-primary)"
                           autofocus>
                </div>
            </div>

            {{-- Toggle Region --}}
            <div class="region-toggle">
                <button type="submit" name="region" value="global"
                        class="region-toggle__option {{ ($region ?? 'global') === 'global' ? 'is-active' : '' }}">
                    🌍 Global
                </button>
                <button type="submit" name="region" value="indonesia"
                        class="region-toggle__option {{ ($region ?? 'global') === 'indonesia' ? 'is-active' : '' }}">
                    🇮🇩 Indonesia
                </button>
            </div>

            {{-- Tombol Cari --}}
            <button type="submit"
                    style="background:var(--accent);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.5rem;font-family:'Syne',sans-serif;font-weight:700;cursor:pointer">
                <i class="bi bi-search me-1"></i> Cari
            </button>

        </div>
    </form>

    {{-- Error --}}
    @if(isset($error))
        <div class="mb-3" style="color:#ff6b7a;font-size:0.88rem">
            <i class="bi bi-exclamation-circle me-1"></i> {{ $error }}
        </div>
    @endif

    {{-- Hasil pencarian --}}
    @if(isset($query) && strlen($query) >= 2)
        <div class="mb-3" style="color:var(--text-muted);font-size:0.88rem">
            @if(count($films) > 0)
                Ditemukan <strong style="color:var(--text-primary)">{{ count($films) }}</strong>
                film untuk "<strong style="color:var(--accent)">{{ $query }}</strong>"
                di region <strong style="color:var(--text-primary)">{{ $region === 'indonesia' ? 'Indonesia' : 'Global' }}</strong>
            @else
                Tidak ada film ditemukan untuk "<strong style="color:var(--accent)">{{ $query }}</strong>"
            @endif
        </div>

        @if(count($films) > 0)
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
            @foreach($films as $film)
            <div class="col">
                <a href="{{ route('films.detail', $film['movie_id']) }}"
                   class="film-card position-relative d-block text-decoration-none text-reset">

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
                        <div class="card-title">{{ $film['title'] }}</div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small style="color:#ffffff">{{ $film['year'] ?? '-' }}</small>
                            <span class="rating-stars">
                                <i class="bi bi-star-fill" style="font-size:0.7rem"></i>
                                <small style="color:#ffffff">
                                    {{ number_format($film['avg_rating'] ?? 0, 1) }}
                                </small>
                            </span>
                        </div>

                        <div class="mt-1" style="font-size:0.72rem;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $film['genre'] ?? '' }}
                        </div>

                        <span class="btn btn-accent btn-sm w-100 mt-2 d-block text-center">
                            <i class="bi bi-play-fill me-1"></i> Lihat Detail
                        </span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    @endif

</div>
@endsection