{{-- =============================================================================
resources/views/layouts/app.blade.php
============================================================================= --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CineMatch - Rekomendasi Film')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-dark     : #0a0a0f;
            --bg-card     : #12121a;
            --bg-elevated : #1a1a26;
            --accent      : #e63946;
            --accent-soft : #ff6b6b;
            --text-primary: #f0f0f5;
            --text-muted  : #8888aa;
            --border      : #2a2a3a;
        }

        * { box-sizing: border-box; }

        body {
            background-color : var(--bg-dark);
            color            : var(--text-primary);
            font-family      : 'DM Sans', sans-serif;
            min-height       : 100vh;
        }

        h1, h2, h3, h4, h5, .brand {
            font-family : 'Syne', sans-serif;
        }

        /* Navbar */
        .navbar {
            background    : rgba(10, 10, 15, 0.95);
            backdrop-filter: blur(20px);
            border-bottom : 1px solid var(--border);
            padding       : 1rem 0;
        }

        .navbar-brand {
            font-family  : 'Syne', sans-serif;
            font-weight  : 800;
            font-size    : 1.5rem;
            color        : var(--text-primary) !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            color : var(--accent);
        }

        .nav-link {
            color       : var(--text-muted) !important;
            font-weight : 500;
            transition  : color 0.2s;
            padding     : 0.5rem 1rem !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color : var(--text-primary) !important;
        }

        .nav-link.active {
            border-bottom : 2px solid var(--accent);
        }

        /* Cards */
        .film-card {
            background    : var(--bg-card);
            border        : 1px solid var(--border);
            border-radius : 12px;
            overflow      : hidden;
            transition    : transform 0.2s, border-color 0.2s;
            height        : 100%;
        }

        .film-card:hover {
            transform    : translateY(-4px);
            border-color : var(--accent);
        }

        .film-card .poster {
            width      : 100%;
            height     : 240px;
            object-fit : cover;
            background : var(--bg-elevated);
        }

        .film-card .poster-placeholder {
            width           : 100%;
            height          : 240px;
            background      : var(--bg-elevated);
            display         : flex;
            align-items     : center;
            justify-content : center;
            font-size       : 3rem;
            color           : var(--text-muted);
        }

        .film-card .card-body {
            padding : 1rem;
        }

        .film-card .card-title {
            font-family   : 'Syne', sans-serif;
            font-weight   : 700;
            font-size     : 0.95rem;
            margin-bottom : 0.4rem;
            color         : var(--text-primary);
            display       : -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow      : hidden;
        }

        /* Badge genre */
        .badge-genre {
            background    : var(--bg-elevated);
            color         : var(--text-muted);
            border        : 1px solid var(--border);
            border-radius : 20px;
            padding       : 2px 10px;
            font-size     : 0.7rem;
            font-weight   : 500;
        }

        /* Rating stars */
        .rating-stars { color: #ffd700; }

        /* Buttons */
        .btn-accent {
            background    : var(--accent);
            color         : white;
            border        : none;
            border-radius : 8px;
            font-weight   : 600;
            font-family   : 'Syne', sans-serif;
            transition    : opacity 0.2s, transform 0.1s;
        }

        .btn-accent:hover {
            opacity   : 0.9;
            color     : white;
            transform : translateY(-1px);
        }

        .btn-outline-accent {
            background    : transparent;
            color         : var(--accent);
            border        : 1px solid var(--accent);
            border-radius : 8px;
            font-weight   : 600;
            transition    : all 0.2s;
        }

        .btn-outline-accent:hover {
            background : var(--accent);
            color      : white;
        }

        /* Search bar */
        .search-input {
            background    : var(--bg-elevated);
            border        : 1px solid var(--border);
            color         : var(--text-primary);
            border-radius : 8px;
            padding       : 0.6rem 1rem;
        }

        .search-input:focus {
            background   : var(--bg-elevated);
            border-color : var(--accent);
            color        : var(--text-primary);
            box-shadow   : 0 0 0 3px rgba(230, 57, 70, 0.15);
            outline      : none;
        }

        .search-input::placeholder { color: var(--text-muted); }

        /* Form select */
        .form-select-dark {
            background    : var(--bg-elevated);
            border        : 1px solid var(--border);
            color         : var(--text-primary);
            border-radius : 8px;
        }

        .form-select-dark:focus {
            background   : var(--bg-elevated);
            border-color : var(--accent);
            color        : var(--text-primary);
            box-shadow   : none;
        }

        /* Alert */
        .alert-success {
            background : rgba(40, 167, 69, 0.15);
            border     : 1px solid rgba(40, 167, 69, 0.3);
            color      : #75d787;
        }

        .alert-danger {
            background : rgba(230, 57, 70, 0.15);
            border     : 1px solid rgba(230, 57, 70, 0.3);
            color      : var(--accent-soft);
        }

        /* Section title */
        .section-title {
            font-family   : 'Syne', sans-serif;
            font-weight   : 800;
            font-size     : 1.8rem;
            margin-bottom : 0.25rem;
        }

        .section-title span { color: var(--accent); }

        /* Footer */
        footer {
            background   : var(--bg-card);
            border-top   : 1px solid var(--border);
            padding      : 2rem 0;
            margin-top   : 4rem;
            color        : var(--text-muted);
            font-size    : 0.875rem;
            text-align   : center;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* Page transitions */
        main { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    @yield('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            Cine<span>Match</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list text-white fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('films.*') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        <i class="bi bi-film me-1"></i> Film
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }}"
                       href="{{ route('rekomendasi.index') }}">
                        <i class="bi bi-stars me-1"></i> Rekomendasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rating.*') ? 'active' : '' }}"
                       href="/rating/1">
                        <i class="bi bi-star me-1"></i> Rating Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                       href="{{ route('admin.index') }}">
                        <i class="bi bi-shield me-1"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- Main Content --}}
<main class="container py-4">
    @yield('content')
</main>

{{-- Footer --}}
<footer>
    <div class="container">
        <p class="mb-1">
            <strong style="font-family:'Syne',sans-serif; color:var(--text-primary)">
                CineMatch
            </strong>
            — Sistem Rekomendasi Film
        </p>
        <p class="mb-0">
            Tugas Akhir · Abima Fadricho Syuhadak · NIM 2241720025 · Politeknik Negeri Malang 2026
        </p>
    </div>
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>