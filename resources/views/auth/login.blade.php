<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — CineMatch</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-main     : #0a0a0f;
            --bg-card     : #111118;
            --bg-elevated : #1a1a24;
            --accent      : #e63946;
            --accent-soft : #c1121f;
            --border      : rgba(255,255,255,0.08);
            --text-primary: #f0f0f5;
            --text-muted  : #8888a0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background    : var(--bg-main);
            color         : var(--text-primary);
            font-family   : 'DM Sans', sans-serif;
            min-height    : 100vh;
            display       : flex;
            align-items   : center;
            justify-content: center;
            padding       : 1.5rem;
        }

        /* Background decorative blur */
        body::before {
            content   : '';
            position  : fixed;
            top       : -200px;
            right     : -200px;
            width     : 600px;
            height    : 600px;
            background: radial-gradient(circle, rgba(230,57,70,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-card {
            background   : var(--bg-card);
            border       : 1px solid var(--border);
            border-radius: 16px;
            padding      : 2.5rem 2rem;
            width        : 100%;
            max-width    : 420px;
            box-shadow   : 0 20px 60px rgba(0,0,0,0.5);
        }

        .auth-logo {
            font-family : 'Syne', sans-serif;
            font-size   : 1.6rem;
            font-weight : 800;
            color       : var(--text-primary);
            text-align  : center;
            margin-bottom: 0.25rem;
        }

        .auth-logo span { color: var(--accent); }

        .auth-subtitle {
            text-align  : center;
            color       : var(--text-muted);
            font-size   : 0.88rem;
            margin-bottom: 2rem;
        }

        .form-label {
            color      : var(--text-muted);
            font-size  : 0.82rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-control {
            background   : var(--bg-elevated);
            border       : 1px solid var(--border);
            border-radius: 10px;
            color        : var(--text-primary);
            padding      : 0.75rem 1rem;
            font-size    : 0.95rem;
            transition   : border-color 0.2s;
        }

        .form-control:focus {
            background  : var(--bg-elevated);
            border-color: var(--accent);
            color       : var(--text-primary);
            box-shadow  : 0 0 0 3px rgba(230,57,70,0.15);
            outline     : none;
        }

        .form-control::placeholder { color: var(--text-muted); }

        .input-group-text {
            background  : var(--bg-elevated);
            border      : 1px solid var(--border);
            border-right: none;
            color       : var(--text-muted);
        }

        .input-group .form-control { border-left: none; }

        .btn-auth {
            background   : linear-gradient(135deg, var(--accent), var(--accent-soft));
            color        : #fff;
            border       : none;
            border-radius: 10px;
            padding      : 0.8rem;
            font-family  : 'Syne', sans-serif;
            font-weight  : 700;
            font-size    : 0.95rem;
            width        : 100%;
            cursor       : pointer;
            transition   : opacity 0.2s, transform 0.1s;
            box-shadow   : 0 4px 15px rgba(230,57,70,0.3);
        }

        .btn-auth:hover   { opacity: 0.9; transform: translateY(-1px); }
        .btn-auth:active  { transform: translateY(0); }

        .divider {
            display    : flex;
            align-items: center;
            gap        : 1rem;
            margin     : 1.5rem 0;
            color      : var(--text-muted);
            font-size  : 0.8rem;
        }

        .divider::before,
        .divider::after {
            content   : '';
            flex      : 1;
            height    : 1px;
            background: var(--border);
        }

        .auth-link {
            text-align : center;
            font-size  : 0.88rem;
            color      : var(--text-muted);
        }

        .auth-link a {
            color          : var(--accent);
            text-decoration: none;
            font-weight    : 600;
        }

        .auth-link a:hover { text-decoration: underline; }

        .alert-danger {
            background  : rgba(230,57,70,0.1);
            border      : 1px solid rgba(230,57,70,0.3);
            border-radius: 10px;
            color       : #ff6b7a;
            font-size   : 0.88rem;
            padding     : 0.75rem 1rem;
        }

        .alert-success {
            background  : rgba(34,197,94,0.1);
            border      : 1px solid rgba(34,197,94,0.3);
            border-radius: 10px;
            color       : #4ade80;
            font-size   : 0.88rem;
            padding     : 0.75rem 1rem;
        }

        .invalid-feedback { color: #ff6b7a; font-size: 0.82rem; }
        .is-invalid { border-color: var(--accent) !important; }
    </style>
</head>
<body>

<div class="auth-card">
    {{-- Logo --}}
    <div class="auth-logo">Cine<span>Match</span></div>
    <p class="auth-subtitle">Sistem Rekomendasi Film dengan IBCF + Timestamp</p>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert-success mb-3">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger mb-3">
            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Form Login --}}
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="nama@email.com"
                       value="{{ old('email') }}"
                       autofocus>
            </div>
            @error('email')
                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••">
            </div>
            @error('password')
                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
        </button>
    </form>

    <div class="divider">atau</div>

    <div class="auth-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</div>

</body>
</html>