<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — DigiRepo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ke-black: #1B1B1B;
            --ke-red: #BE0027;
            --ke-green: #006B3F;
            --ke-white: #FFFFFF;
            --ke-green-dark: #005232;
            --ke-red-dark: #9A001F;
            --ke-red-soft: rgba(190, 0, 39, 0.08);
            --ke-green-soft: rgba(0, 107, 63, 0.08);
            --glass-bg: rgba(255, 255, 255, 0.55);
            --glass-border: rgba(255, 255, 255, 0.45);
            --glass-shadow: rgba(0, 0, 0, 0.06);
            --text: #1B1B1B;
            --text-muted: #6B7280;
            --border: rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            background: #E8ECF1;
            color: var(--text);
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════
           KENYAN FLAG — THREE HORIZONTAL LINES
        ═══════════════════════════════════════ */
        .flag-bar {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            width: 100%;
            position: relative;
            z-index: 100;
            background: #E8ECF1;
        }
        .flag-line {
            width: 100%;
            height: 5px;
            position: relative;
        }
        .flag-line:nth-child(1) {
            background: var(--ke-black);
        }
        .flag-line:nth-child(2) {
            background: var(--ke-red);
            margin-top: 3px;
        }
        .flag-line:nth-child(3) {
            background: var(--ke-green);
            margin-top: 3px;
        }

        /* Soft colored glow bleeding down from each line */
        .flag-line::after {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 16px;
            border-radius: 0 0 50% 50%;
            opacity: 0.5;
        }
        .flag-line:nth-child(1)::after {
            background: linear-gradient(180deg, rgba(27,27,27,0.08), transparent);
        }
        .flag-line:nth-child(2)::after {
            background: linear-gradient(180deg, rgba(190,0,39,0.07), transparent);
        }
        .flag-line:nth-child(3)::after {
            background: linear-gradient(180deg, rgba(0,107,63,0.07), transparent);
        }

        /* ═══════════════════════════════════════
           MAIN SCENE — GLASSMORPHISM
        ═══════════════════════════════════════ */
        .scene {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem 1.5rem 3rem;
            overflow: hidden;
            min-height: 0;
        }

        .scene-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 80%, rgba(0, 107, 63, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 70% 50% at 85% 20%, rgba(190, 0, 39, 0.10) 0%, transparent 55%),
                radial-gradient(ellipse 90% 70% at 50% 50%, rgba(27, 27, 27, 0.04) 0%, transparent 70%),
                linear-gradient(160deg, #E8ECF1 0%, #DDE3EA 40%, #E2E7EE 100%);
            z-index: 0;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 1;
            animation: blobFloat 18s ease-in-out infinite alternate;
        }
        .blob-1 {
            width: 340px; height: 340px;
            background: rgba(0, 107, 63, 0.18);
            top: -80px; left: -60px;
            animation-duration: 20s;
        }
        .blob-2 {
            width: 280px; height: 280px;
            background: rgba(190, 0, 39, 0.14);
            bottom: -60px; right: -40px;
            animation-duration: 16s;
            animation-delay: -4s;
        }
        .blob-3 {
            width: 200px; height: 200px;
            background: rgba(27, 27, 27, 0.08);
            top: 30%; right: 15%;
            animation-duration: 22s;
            animation-delay: -8s;
        }
        .blob-4 {
            width: 160px; height: 160px;
            background: rgba(0, 107, 63, 0.10);
            bottom: 20%; left: 10%;
            animation-duration: 19s;
            animation-delay: -12s;
        }
        .blob-5 {
            width: 120px; height: 120px;
            background: rgba(190, 0, 39, 0.08);
            top: 15%; left: 40%;
            animation-duration: 24s;
            animation-delay: -6s;
        }

        @keyframes blobFloat {
            0%   { transform: translate(0, 0) scale(1); }
            33%  { transform: translate(30px, -20px) scale(1.05); }
            66%  { transform: translate(-20px, 15px) scale(0.95); }
            100% { transform: translate(15px, -10px) scale(1.02); }
        }

        .chip {
            position: absolute;
            border-radius: 16px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 24px var(--glass-shadow);
            z-index: 2;
            opacity: 0.5;
        }
        .chip-1 { width: 60px; height: 60px; top: 12%; left: 8%; transform: rotate(15deg); animation: chipDrift 12s ease-in-out infinite; }
        .chip-2 { width: 44px; height: 44px; top: 22%; right: 10%; transform: rotate(-20deg); animation: chipDrift 15s ease-in-out infinite reverse; }
        .chip-3 { width: 52px; height: 52px; bottom: 18%; left: 12%; transform: rotate(25deg); animation: chipDrift 18s ease-in-out infinite; animation-delay: -3s; }
        .chip-4 { width: 36px; height: 36px; bottom: 25%; right: 8%; transform: rotate(-10deg); animation: chipDrift 14s ease-in-out infinite reverse; animation-delay: -7s; }
        .chip-5 { width: 48px; height: 48px; top: 55%; left: 4%; transform: rotate(35deg); animation: chipDrift 20s ease-in-out infinite; animation-delay: -10s; }

        @keyframes chipDrift {
            0%, 100% { transform: rotate(15deg) translateY(0); opacity: 0.5; }
            50%      { transform: rotate(20deg) translateY(-12px); opacity: 0.7; }
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            z-index: 1;
            opacity: 0.025;
            background-image:
                linear-gradient(rgba(0,0,0,0.5) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.5) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* ═══════════════════════════════════════
           GLASS LOGIN CARD
        ═══════════════════════════════════════ */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: var(--glass-bg);
            backdrop-filter: blur(40px) saturate(1.6);
            -webkit-backdrop-filter: blur(40px) saturate(1.6);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2.75rem 2.5rem 2.5rem;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.06),
                0 2px 8px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            animation: cardEntry 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardEntry {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 24px; right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
            border-radius: 1px;
        }

        .card-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-icon-wrap {
            width: 64px; height: 64px;
            margin: 0 auto 1rem;
            border-radius: 18px;
            background: linear-gradient(145deg, var(--ke-green), var(--ke-green-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow:
                0 6px 20px rgba(0, 107, 63, 0.35),
                inset 0 1px 0 rgba(255,255,255,0.2);
            position: relative;
        }
        .brand-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 21px;
            border: 1.5px solid rgba(0, 107, 63, 0.15);
        }
        .card-brand h1 {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--ke-black);
            letter-spacing: -0.025em;
            margin-bottom: 0.25rem;
        }
        .card-brand p {
            font-size: 0.84rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .session-status {
            padding: 0.7rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--ke-green-soft);
            color: var(--ke-green-dark);
            border: 1px solid rgba(0, 107, 63, 0.12);
            backdrop-filter: blur(8px);
        }
        .session-status i { font-size: 0.8rem; }

        .field-group { margin-bottom: 1.1rem; }

        .field-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            letter-spacing: 0.01em;
        }

        .field-input-wrap { position: relative; }

        .field-input-wrap i.field-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 0.82rem;
            pointer-events: none;
            transition: color 0.25s;
        }

        .field-input {
            width: 100%;
            padding: 0.72rem 0.9rem 0.72rem 2.5rem;
            border: 1.5px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            font-size: 0.87rem;
            font-family: inherit;
            color: var(--text);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: all 0.25s ease;
            outline: none;
        }
        .field-input::placeholder { color: #B8BFC8; }
        .field-input:focus {
            border-color: var(--ke-green);
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 0 0 3.5px rgba(0, 107, 63, 0.1), 0 2px 8px rgba(0,0,0,0.04);
        }
        .field-input:focus ~ i.field-icon { color: var(--ke-green); }
        .field-input.has-error {
            border-color: var(--ke-red);
            box-shadow: 0 0 0 3.5px rgba(190, 0, 39, 0.08);
        }

        .field-error {
            font-size: 0.72rem;
            color: var(--ke-red);
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }
        .field-error i { font-size: 0.62rem; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            user-select: none;
        }
        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--ke-green);
            border-radius: 4px;
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.8rem;
            color: var(--ke-green);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }
        .forgot-link:hover { color: var(--ke-green-dark); text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 0.78rem;
            background: linear-gradient(135deg, var(--ke-green) 0%, var(--ke-green-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow:
                0 4px 14px rgba(0, 107, 63, 0.3),
                inset 0 1px 0 rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
            transition: left 0.6s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0, 107, 63, 0.4), inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .btn-login:hover::before { left: 100%; }
        .btn-login:active { transform: translateY(0) scale(0.98); }
        .btn-login i { font-size: 0.78rem; }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,0,0,0.08), transparent);
        }
        .divider span {
            font-size: 0.72rem;
            color: #9CA3AF;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .card-footer {
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
        }
        .card-footer a {
            color: var(--ke-green);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .card-footer a:hover { color: var(--ke-green-dark); text-decoration: underline; }

        /* ── Bottom ribbon with matching 3-line flag ── */
        .bottom-ribbon {
            flex-shrink: 0;
            padding: 1rem 0 1.25rem;
            text-align: center;
            position: relative;
            z-index: 10;
        }
        .bottom-flag-lines {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            margin-bottom: 0.6rem;
        }
        .bottom-flag-lines .bl {
            height: 3px;
            border-radius: 2px;
        }
        .bottom-flag-lines .bl:nth-child(1) { width: 48px; background: var(--ke-black); }
        .bottom-flag-lines .bl:nth-child(2) { width: 48px; background: var(--ke-red); }
        .bottom-flag-lines .bl:nth-child(3) { width: 48px; background: var(--ke-green); }
        .bottom-ribbon p {
            font-size: 0.72rem;
            color: #9CA3AF;
            font-weight: 400;
            letter-spacing: 0.01em;
        }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.5rem 1.75rem; border-radius: 20px; }
            .card-brand h1 { font-size: 1.3rem; }
            .brand-icon-wrap { width: 56px; height: 56px; font-size: 1.3rem; border-radius: 15px; }
            .chip { display: none; }
            .blob-3, .blob-5 { display: none; }
            .scene { padding: 1.5rem 1rem 2rem; }
        }
    </style>
</head>
<body>

    <!-- ═══════ KENYAN FLAG — THREE HORIZONTAL LINES ═══════ -->
    <div class="flag-bar">
        <div class="flag-line"></div>
        <div class="flag-line"></div>
        <div class="flag-line"></div>
    </div>

    <!-- ═══════ GLASSMORPHISM SCENE ═══════ -->
    <div class="scene">

        <div class="scene-bg"></div>
        <div class="grid-pattern"></div>

        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
        <div class="blob blob-5"></div>

        <div class="chip chip-1"></div>
        <div class="chip chip-2"></div>
        <div class="chip chip-3"></div>
        <div class="chip chip-4"></div>
        <div class="chip chip-5"></div>

        <!-- ═══════ LOGIN CARD ═══════ -->
        <div class="login-card">

            <div class="card-brand">
                <div class="brand-icon-wrap">
                    <i class="fas fa-landmark"></i>
                </div>
                <h1>DigiRepo</h1>
                <p>Sign in to your digital repository</p>
            </div>

            @if(session('status'))
                <div class="session-status">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="email">Email Address</label>
                    <div class="field-input-wrap">
                        <input id="email"
                               class="field-input {{ $errors->has('email') ? 'has-error' : '' }}"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="you@example.com">
                        <i class="field-icon fas fa-envelope"></i>
                    </div>
                    @if($errors->has('email'))
                        <div class="field-error">
                            <i class="fas fa-circle-exclamation"></i>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-input-wrap">
                        <input id="password"
                               class="field-input {{ $errors->has('password') ? 'has-error' : '' }}"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your password">
                        <i class="field-icon fas fa-lock"></i>
                    </div>
                    @if($errors->has('password'))
                        <div class="field-error">
                            <i class="fas fa-circle-exclamation"></i>
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="remember-row">
                    <label class="remember-label" for="remember_me">
                        <input type="checkbox" name="remember" id="remember_me">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    Sign In
                </button>
            </form>

            <div class="divider">
                <span>or</span>
            </div>

            <div class="card-footer">
                Don't have an account?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Create one</a>
                @else
                    Contact your administrator
                @endif
            </div>

        </div>
    </div>

    <!-- ═══════ BOTTOM RIBBON ═══════ -->
    <div class="bottom-ribbon">
        <div class="bottom-flag-lines">
            <div class="bl"></div>
            <div class="bl"></div>
            <div class="bl"></div>
        </div>
        <p>DigiRepo Digital Repository System</p>
    </div>

</body>
</html>