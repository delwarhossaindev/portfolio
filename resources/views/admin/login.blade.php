<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in - Portfolio Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg: #0b0d14;
            --surface: rgba(18, 21, 31, 0.72);
            --field: #12151f;
            --border: rgba(255, 255, 255, 0.09);
            --border-strong: rgba(255, 255, 255, 0.16);
            --text: #e6e8ef;
            --muted: #8b93a7;
            --primary: #6366f1;
            --primary-2: #8b5cf6;
            --danger: #fca5a5;
            --warning: #fcd34d;
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }
        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.55;
            pointer-events: none;
            z-index: 0;
        }
        .glow.a { width: 480px; height: 480px; background: #4f46e5; top: -160px; left: -120px; }
        .glow.b { width: 420px; height: 420px; background: #a855f7; bottom: -160px; right: -100px; opacity: 0.4; }
        .grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(ellipse at center, #000 30%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, #000 30%, transparent 75%);
            pointer-events: none;
            z-index: 0;
        }
        .auth {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            animation: rise 0.45s ease both;
        }
        @keyframes rise { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
        @media (prefers-reduced-motion: reduce) { .auth { animation: none; } }

        .brand { text-align: center; margin-bottom: 26px; }
        .brand img {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            box-shadow: 0 12px 30px -8px rgba(99, 102, 241, 0.7);
        }
        .brand h1 { font-size: 22px; font-weight: 800; margin: 16px 0 4px; letter-spacing: -0.02em; color: #fff; }
        .brand p { margin: 0; color: var(--muted); font-size: 14px; }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 28px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 24px 60px -20px rgba(0, 0, 0, 0.7);
        }
        .field { margin-bottom: 16px; }
        .field label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }
        .control { position: relative; }
        .control > i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 14px;
            pointer-events: none;
        }
        .control input {
            width: 100%;
            height: 46px;
            padding: 0 44px 0 40px;
            border-radius: 12px;
            border: 1px solid var(--border-strong);
            background: var(--field);
            color: #fff;
            font: inherit;
            font-size: 14px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .control input::placeholder { color: var(--muted); opacity: 0.7; }
        .control input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.18);
        }
        /* Keep saved-login autofill dark instead of the browser's pale blue */
        .control input:-webkit-autofill,
        .control input:-webkit-autofill:hover {
            -webkit-text-fill-color: #fff !important;
            caret-color: #fff;
            -webkit-box-shadow: 0 0 0 1000px var(--field) inset !important;
            transition: background-color 9999s ease-out 0s;
        }
        .control input:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff !important;
            -webkit-box-shadow: 0 0 0 1000px var(--field) inset, 0 0 0 4px rgba(99, 102, 241, 0.18) !important;
        }
        .control input[aria-invalid="true"] { border-color: rgba(239, 68, 68, 0.6); }
        .peek {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
        }
        .peek:hover { color: #fff; background: rgba(255, 255, 255, 0.06); }
        .error { display: block; color: var(--danger); font-size: 12.5px; margin-top: 6px; }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            color: var(--muted);
            margin: 4px 0 22px;
            cursor: pointer;
            user-select: none;
        }
        .remember input { width: 16px; height: 16px; accent-color: var(--primary); cursor: pointer; }

        .submit {
            width: 100%;
            height: 46px;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            font: inherit;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 10px 24px -8px rgba(99, 102, 241, 0.8);
            transition: filter 0.15s ease, transform 0.15s ease;
        }
        .submit:hover { filter: brightness(1.08); transform: translateY(-1px); }
        .submit:focus-visible, .peek:focus-visible, .back:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
        .submit[disabled] { opacity: 0.7; cursor: progress; transform: none; }

        .notice {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 11px 14px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 18px;
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: var(--warning);
        }
        .notice i { margin-top: 2px; }

        .foot {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: var(--muted);
        }
        .back { color: var(--muted); text-decoration: none; border-radius: 6px; }
        .back:hover { color: #fff; }
    </style>
</head>
<body>
<div class="glow a"></div>
<div class="glow b"></div>
<div class="grid"></div>

<main class="auth">
    <div class="brand">
        <img src="{{ asset('favicon.svg') }}?v=2" alt="">
        <h1>Welcome back</h1>
        <p>Sign in to manage your portfolio</p>
    </div>

    <div class="panel">
        @if(session('lockout'))
            <div class="notice" role="alert">
                <i class="fas fa-clock"></i>
                <span>{{ session('lockout') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="post" autocomplete="on" id="login-form">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <div class="control">
                    <i class="far fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="you@example.com"
                           value="{{ old('email') }}" autocomplete="username" required autofocus
                           @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                </div>
                @error('email') <small class="error" id="email-error">{{ $message }}</small> @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="control">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="••••••••"
                           autocomplete="current-password" required>
                    <button type="button" class="peek" id="peek" aria-label="Show password" aria-pressed="false">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <label class="remember">
                <input type="checkbox" name="remember" id="remember">
                Keep me signed in
            </label>

            <button type="submit" class="submit" id="submit">
                Sign in <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>

    <div class="foot">
        <a href="{{ url('/') }}" class="back"><i class="fas fa-arrow-left" style="font-size:11px"></i> Back to portfolio</a>
    </div>
</main>

<script>
    (function () {
        const peek = document.getElementById('peek');
        const pwd = document.getElementById('password');
        peek.addEventListener('click', function () {
            const show = pwd.type === 'password';
            pwd.type = show ? 'text' : 'password';
            peek.setAttribute('aria-pressed', show);
            peek.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            peek.innerHTML = show ? '<i class="far fa-eye-slash"></i>' : '<i class="far fa-eye"></i>';
        });

        document.getElementById('login-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Signing in…';
        });
    })();
</script>
</body>
</html>
