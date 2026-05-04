@extends('layouts.app')
@section('title', 'Riwayat Rating - CineMatch')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="section-title">Riwayat <span>Rating</span></h1>
        <p class="text-muted mb-0">{{ count($ratings) }} film telah di-rating</p>
    </div>
    <a href="{{ route('rekomendasi.show', $userId) }}" class="btn btn-accent">
        <i class="bi bi-stars me-1"></i> Lihat Rekomendasi
    </a>
</div>

@if(count($ratings) > 0)
    <div class="row g-3">
        @foreach($ratings as $r)
        <div class="col-md-6 col-lg-4">
            <div class="film-card d-flex" style="height:auto">
                {{-- Poster kecil --}}
                <div style="width:70px;min-width:70px">
                    @if(!empty($r['poster']))
                        <img src="{{ $r['poster'] }}" alt=""
                             style="width:100%;height:100%;object-fit:cover">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100"
                             style="background:var(--bg-elevated);color:var(--text-muted)">
                            <i class="bi bi-film"></i>
                        </div>
                    @endif
                </div>

                <div class="p-3 flex-grow-1">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem">
                        {{ $r['title'] }}
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">{{ $r['year'] ?? '' }}</small>
                        <span class="rating-stars">
                            <i class="bi bi-star-fill" style="font-size:0.75rem"></i>
                            <strong>{{ $r['rating'] }}</strong>
                        </span>
                    </div>
                    <small class="text-muted" style="font-size:0.7rem">
                        {{ $r['created_at'] ?? '' }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-star" style="font-size:4rem;color:var(--text-muted)"></i>
        <h4 class="mt-3" style="font-family:'Syne',sans-serif">Belum Ada Rating</h4>
        <p class="text-muted">Mulai beri rating pada film yang sudah kamu tonton</p>
        <a href="{{ route('films.index') }}" class="btn btn-accent mt-2">
            <i class="bi bi-film me-1"></i> Lihat Daftar Film
        </a>
    </div>
@endif

@endsection