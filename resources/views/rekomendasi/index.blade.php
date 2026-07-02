@extends('layouts.app')
@section('title', 'Rekomendasi Film - CineMatch')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="text-center mb-5">
            <h1 class="section-title">Rekomendasi <span>Personal</span></h1>
            <p class="text-muted">Masukkan User ID untuk mendapatkan rekomendasi film yang dipersonalisasi</p>
        </div>

        <div class="p-4 rounded-3" style="background:var(--bg-card);border:1px solid var(--border)">
            <form  method="GET" id="formRekomendasi" onsubmit="return false;">

                <div class="mb-3">
                    <label class="form-label text-muted">User ID</label>
                    <input type="number" id="userId" name="user_id"
                           class="search-input w-100"
                           placeholder="Contoh: 1, 100, 500"
                           min="1" required>
                    <small class="text-muted">Gunakan User ID dari dataset training</small>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted">Nilai K (KNN)</label>
                        <select name="k" class="form-select form-select-dark">
                            <option value="10">K = 10</option>
                            <option value="20" selected>K = 20</option>
                            <option value="30">K = 30</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted">Jumlah Rekomendasi</label>
                        <select name="top_n" class="form-select form-select-dark">
                            <option value="5">Top 5</option>
                            <option value="10" selected>Top 10</option>
                            <option value="20">Top 20</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-accent w-100 py-2"
                        onclick="submitForm()">
                    <i class="bi bi-stars me-2"></i> Dapatkan Rekomendasi
                </button>
            </form>
        </div>

        {{-- Info --}}
        <div class="mt-4 p-3 rounded-3" style="background:var(--bg-elevated);border:1px solid var(--border)">
            <h6 style="font-family:'Syne',sans-serif"><i class="bi bi-info-circle me-2 text-warning"></i>Cara Kerja</h6>
            <ul class="text-muted small mb-0" style="padding-left:1.2rem">
                <li>Sistem menggunakan algoritma <strong>Item-Based Collaborative Filtering</strong></li>
                <li>Timestamp interaksi digunakan sebagai bobot untuk memprioritaskan preferensi terbaru</li>
                <li>Semakin banyak film yang di-rating, semakin akurat rekomendasinya</li>
            </ul>
        </div>
    </div>
</div>

@section('scripts')
<script>
function submitForm() {
    const userId = document.getElementById('userId').value;
    if (!userId) {
        alert('Masukkan User ID terlebih dahulu!');
        return;
    }
    const k     = document.querySelector('select[name="k"]').value;
    const topN  = document.querySelector('select[name="top_n"]').value;
    const url   = `{{ url('/rekomendasi') }}/${userId}?k=${k}&top_n=${topN}`;
    window.location.href = url;
}
</script>
@endsection

@endsection