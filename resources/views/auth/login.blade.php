<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Panel Pengelola | Stasiun Klimatologi Papua Selatan - BMKG</title>

    <!-- Google Fonts: Plus Jakarta Sans (Standar Institusional BMKG) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bmkg-navy: #002b49;
            --bmkg-navy-dark: #00192b;
            --bmkg-navy-light: #0a3d62;
            --bmkg-blue: #0284c7;
            --bmkg-blue-dark: #0369a1;
            --bmkg-blue-light: #e0f2fe;
            --bmkg-cyan: #0ea5e9;
            --bmkg-cyan-soft: #f0f9ff;
            --ink: #0f172a;
            --ink-secondary: #334155;
            --muted: #64748b;
            --line: #e2e8f0;
            --card-bg: #ffffff;
            --paper: #f4f8fb;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 9999px;
            --shadow-card: 0 16px 36px -8px rgba(0, 43, 73, 0.14), 0 4px 12px rgba(0, 43, 73, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #00192b 0%, #002b49 50%, #0a3d62 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: var(--ink);
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle background decorative shapes */
        body::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(2, 132, 199, 0.18) 0%, rgba(2, 132, 199, 0) 70%);
            top: -150px;
            right: -150px;
            border-radius: 50%;
            pointer-events: none;
        }
        body::after {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0) 70%);
            bottom: -150px;
            left: -150px;
            border-radius: 50%;
            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: 36px 32px;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 14px;
            filter: drop-shadow(0 4px 6px rgba(0, 43, 73, 0.12));
        }

        .brand-inst {
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .08em;
            color: var(--bmkg-blue);
            text-transform: uppercase;
            display: block;
            margin-bottom: 4px;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.01em;
            line-height: 1.25;
            margin-bottom: 6px;
        }

        .brand-desc {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.45;
        }

        /* Alerts */
        .alert {
            padding: 12px 14px;
            border-radius: var(--radius-md);
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.4;
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .alert-error strong {
            display: block;
            font-size: 13px;
            margin-bottom: 2px;
        }
        .alert-error span {
            font-weight: 500;
            color: #b91c1c;
        }
        .form-input.is-invalid {
            border-color: #ef4444 !important;
            background: #fff7f7;
        }
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink-secondary);
            margin-bottom: 6px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--muted);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-input {
            width: 100%;
            height: 44px;
            padding: 10px 14px 10px 42px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--ink);
            background: #f8fafc;
            border: 1.5px solid var(--line);
            border-radius: var(--radius-md);
            transition: all .2s ease;
            outline: none;
        }
        .form-input:focus {
            background: #ffffff;
            border-color: var(--bmkg-blue);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        .btn-toggle-pwd {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .2s;
        }
        .btn-toggle-pwd:hover {
            color: var(--bmkg-navy);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            font-size: 12.5px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--ink-secondary);
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox {
            width: 16px;
            height: 16px;
            accent-color: var(--bmkg-navy);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, var(--bmkg-navy) 0%, var(--bmkg-navy-light) 100%);
            color: #ffffff;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s ease;
            box-shadow: 0 4px 12px rgba(0, 43, 73, 0.25);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--bmkg-navy-dark) 0%, var(--bmkg-navy) 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 43, 73, 0.32);
        }
        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--bmkg-blue);
            text-decoration: none;
            width: 100%;
            transition: color .2s;
        }
        .back-link:hover {
            color: var(--bmkg-navy);
            text-decoration: underline;
        }

        .login-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 11.5px;
            color: rgba(255, 255, 255, 0.65);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 20px;
            }
            .brand-title {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-header">
                <img class="brand-logo" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG">
                <span class="brand-inst">Badan Meteorologi, Klimatologi, dan Geofisika</span>
                <h1 class="brand-title">Stasiun Klimatologi Papua Selatan</h1>
                <p class="brand-desc">Masuk untuk mengelola data HTH, Peringatan Dini, Dasarian, dan Diseminasi Informasi.</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if(!empty($loginAlert) || $errors->any())
                <div class="alert alert-error" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        @if(!empty($loginAlert))
                            <strong>{{ $loginAlert['title'] }}</strong>
                            <span>{{ $loginAlert['text'] }}</span>
                        @else
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            <form method="POST" action="/login" autocomplete="on">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input id="email" type="email" name="email" class="{{ $emailClass ?? 'form-input' }}" value="{{ $emailValue ?? old('email', 'staklim.merauke@gmail.com') }}" required @if(!empty($emailAutofocus)) autofocus @endif placeholder="staklim.merauke@gmail.com">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input id="password" type="password" name="password" class="{{ $passwordClass ?? 'form-input' }}" required placeholder="Masukkan kata sandi" @if(!empty($passwordAutofocus)) autofocus @endif>
                        <button type="button" class="btn-toggle-pwd" id="togglePassword" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" class="remember-checkbox" {{ old('remember') ? 'checked' : '' }}>
                        Ingat sesi saya
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Panel Pengelola</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>

                <a href="/" class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Kembali ke Portal Publik
                </a>
            </form>
        </div>

        <div class="login-footer">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Sistem Terotentikasi Resmi BMKG Papua Selatan
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            if (isPassword) {
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        });
    </script>
</body>
</html>
