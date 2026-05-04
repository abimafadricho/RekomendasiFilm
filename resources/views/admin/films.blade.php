@extends('layouts.app')
@section('title', 'Kelola Film - Admin CineMatch')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="section-title">Kelola <span>Film</span></h1>
        <p class="text-muted mb-0">Tambah dan hapus data film</p>
    </div>
    <a href="{{ route('admin.index') }}" class="btn btn-outline-accent">
        <i class="bi bi-arrow-left me-1"></i> Dashboard
    </a>
</div>

{{-- Form Tambah Film --}}
<div class="p-4 rounded-3 mb-4" style="background:var(--bg-card);border:1px solid var(--border)">
    <h5 style="font-family:'Syne',sans-serif">
        <i class="bi bi-plus-circle me-2" style="color:var(--accent)"></i>Tambah Film Baru
    </h5>

    <form action="{{ route('admin.films.tambah') }}" method="POST" class="mt-3">
        @csrf
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label text-muted small">Judul Film *</label>
                <input type="text" name="title" class="search-input w-100"
                       placeholder="Contoh: Inception (2010)" required>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small">Genre *</label>
                <input type="text" name="genre" class="search-input w-100"
                       placeholder="Action|Drama|Sci-Fi" required>
            </div>
            <div class="col-md-2">
                <label class="form-label text-muted small">Tahun Rilis *</label>
                <input type="number" name="year" class="search-input w-100"
                       placeholder="2024" min="1888" max="2030" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-accent w-100">
                    <i class="bi bi-plus me-1"></i> Tambah
                </button>
            </div>
            <div class="col-12">
                <label class="form-label text-muted small">Deskripsi (opsional)</label>
                <textarea name="description" class="search-input w-100" rows="2"
                          placeholder="Sinopsis singkat film..."></textarea>
            </div>
        </div>
    </form>
</div>

{{-- Tabel Film --}}
<div class="rounded-3 overflow-hidden" style="border:1px solid var(--border)">
    <table class="table mb-0" style="color:var(--text-primary)">
        <thead style="background:var(--bg-elevated)">
            <tr>
                <th class="py-3 px-4" style="color:var(--text-muted);font-weight:500">ID</th>
                <th class="py-3 px-4" style="color:var(--text-muted);font-weight:500">Judul</th>
                <th class="py-3 px-4" style="color:var(--text-muted);font-weight:500">Genre</th>
                <th class="py-3 px-4" style="color:var(--text-muted);font-weight:500">Tahun</th>
                <th class="py-3 px-4" style="color:var(--text-muted);font-weight:500">Sumber</th>
                <th class="py-3 px-4" style="color:var(--text-muted);font-weight:500">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($films as $film)
            <tr style="border-color:var(--border)">
                <td class="py-3 px-4 text-muted">{{ $film->id }}</td>
                <td class="py-3 px-4">
                    <a href="{{ route('films.detail', $film->id) }}"
                       class="text-decoration-none" style="color:var(--text-primary)">
                        {{ $film->title }}
                    </a>
                </td>
                <td class="py-3 px-4">
                    @foreach(array_slice(explode('|', $film->genre ?? ''), 0, 2) as $g)
                        <span class="badge-genre me-1">{{ $g }}</span>
                    @endforeach
                </td>
                <td class="py-3 px-4 text-muted">{{ $film->year ?? '-' }}</td>
                <td class="py-3 px-4">
                    <span class="badge" style="background:var(--bg-elevated);color:var(--text-muted)">
                        {{ $film->sumber ?? 'manual' }}
                    </span>
                </td>
                <td class="py-3 px-4">
                    <form action="{{ route('admin.films.hapus', $film->id) }}"
                          method="POST" style="display:inline"
                          onsubmit="return confirm('Yakin hapus film ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm"
                                style="background:rgba(230,57,70,0.15);color:var(--accent);border:1px solid rgba(230,57,70,0.3)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    <i class="bi bi-film d-block mb-2" style="font-size:2rem"></i>
                    Belum ada data film
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-center">
    {{ $films->links() }}
</div>

@endsection