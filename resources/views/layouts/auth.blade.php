<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HBYS Core - Hastane Bilgi Yönetim Sistemi">
    <title>HBYS — @yield('title', 'Giriş')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --hbys-blue: #1a56db;
            --hbys-dark: #0f172a;
            --hbys-surface: #1e293b;
        }

        body {
            background: linear-gradient(135deg, var(--hbys-dark) 0%, var(--hbys-surface) 60%, #1a3a5c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .auth-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2rem;
        }

        .auth-logo .logo-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #1a56db, #3b82f6);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            box-shadow: 0 4px 20px rgba(26,86,219,0.4);
        }

        .auth-logo .logo-text {
            color: white;
        }

        .auth-logo .logo-text strong {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
            line-height: 1;
        }

        .auth-logo .logo-text small {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.05em;
        }

        .auth-card h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .auth-card .subtitle {
            color: rgba(255,255,255,0.45);
            font-size: 0.875rem;
            margin-bottom: 1.8rem;
        }

        .form-label {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            color: white;
            padding: 0.65rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.09);
            border-color: #1a56db;
            color: white;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.25);
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .form-select option {
            background: #1e293b;
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a56db, #2563eb);
            border: none;
            border-radius: 10px;
            padding: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 15px rgba(26,86,219,0.4);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26,86,219,0.55);
        }

        .divider {
            color: rgba(255,255,255,0.25);
            font-size: 0.8rem;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        .auth-link {
            color: #60a5fa;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .auth-link:hover {
            color: #93c5fd;
            text-decoration: underline;
        }

        .invalid-feedback { color: #f87171; }
        .is-invalid {
            border-color: #ef4444 !important;
        }

        .alert-danger {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 10px;
            font-size: 0.875rem;
        }

        .alert-success {
            background: rgba(34,197,94,0.12);
            border: 1px solid rgba(34,197,94,0.3);
            color: #86efac;
            border-radius: 10px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo-icon">
                <i class="fa-solid fa-hospital-user"></i>
            </div>
            <div class="logo-text">
                <strong>HBYS</strong>
                <small>HASTANE YÖNETİM SİSTEMİ</small>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
