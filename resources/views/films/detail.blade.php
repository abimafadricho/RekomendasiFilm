@extends('layouts.app')
@section('title', ($film['title'] ?? 'Detail Film') . ' - CineMatch')
@section('content')

<div class="row g-4">
    {{-- Poster --}}
    <div class="col-md-3">
        @if(!empty($film['poster']))
            <img src="{{ $film['poster'] }}" alt="{{ $film['title'] }}"
                 class="img-fluid rounded-3 w-100" style="max-height:400px;object-fit:cover">
        @else
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="height:400px;background:var(--bg-elevated);color:var(--text-muted);font-size:5rem">
                <i class="bi bi-film"></i>
            </div>
        @endif
    </div>

    {{-- Info Film --}}
    <div class="col-md-9">
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge" style="background:var(--accent)">{{ $film['year'] ?? '-' }}</span>
            @foreach(array_slice(explode('|', $film['genre'] ?? ''), 0, 3) as $g)
                <span class="badge-genre">{{ $g }}</span>
            @endforeach
        </div>

        <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:2rem">
            {{ $film['title'] }}
        </h1>

        {{-- Rating Info --}}
        <div class="d-flex align-items-center gap-3 my-3">
            @if(($film['avg_rating'] ?? 0) > 0)
                <div class="d-flex align-items-center gap-1">
                    <i class="bi bi-star-fill text-warning"></i>
                    <span style="font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:700">
                        {{ number_format($film['avg_rating'], 1) }}
                    </span>
                    <span class="text-muted">/5</span>
                </div>
                <span class="text-muted">
                    {{ number_format($film['total_rating']) }} rating
                </span>
            @else
                <span class="text-muted">Belum ada rating</span>
            @endif
        </div>

        @if(!empty($film['description']))
            <p style="color:var(--text-muted);line-height:1.7">{{ $film['description'] }}</p>
        @endif

        {{-- Form Rating --}}
        <div class="mt-4 p-4 rounded-3" style="background:var(--bg-elevated);border:1px solid var(--border)">
            <h5 style="font-family:'Syne',sans-serif">⭐ Beri Rating Film Ini</h5>
            <form action="{{ route('rating.simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id"  value="{{ $userId }}">
                <input type="hidden" name="movie_id" value="{{ $film['id'] }}">

                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-muted small">Rating (0.5 - 5.0)</label>
                        <select name="rating" class="form-select form-select-dark" required>
                            @foreach([0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] as $r)
                                <option value="{{ $r }}" {{ $r == 4 ? 'selected' : '' }}>
                                    {{ $r }} ⭐
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-accent w-100">
                            <i class="bi bi-star-fill me-1"></i> Simpan Rating
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Ulasan Terbaru --}}
@if(!empty($film['ulasan']))
<div class="mt-5">
    <h4 style="font-family:'Syne',sans-serif">Ulasan Terbaru</h4>
    <div class="row g-3 mt-2">
        @foreach($film['ulasan'] as $ulasan)
        <div class="col-md-6">
            <div class="p-3 rounded-3" style="background:var(--bg-elevated);border:1px solid var(--border)">
                <div class="d-flex justify-content-between">
                    <strong>{{ $ulasan['user_name'] ?? 'User' }}</strong>
                    <span class="rating-stars">
                        @for($i=1; $i<=$ulasan['rating']; $i++)
                            <i class="bi bi-star-fill" style="font-size:0.75rem"></i>
                        @endfor
                        <small class="ms-1">{{ $ulasan['rating'] }}</small>
                    </span>
                </div>
                <small class="text-muted">{{ $ulasan['created_at'] }}</small>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection