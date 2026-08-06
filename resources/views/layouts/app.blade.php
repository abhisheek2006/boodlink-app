<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blood Link') - Smart Blood Bank</title>

    @auth
        <meta name="reverb-key" content="{{ config('broadcasting.connections.reverb.key') }}">
        <meta name="reverb-host" content="{{ config('broadcasting.connections.reverb.options.host') }}">
        <meta name="reverb-port" content="{{ config('broadcasting.connections.reverb.options.port') }}">
        <meta name="reverb-scheme" content="{{ config('broadcasting.connections.reverb.options.scheme') }}">
        <meta name="current-user-id" content="{{ auth()->id() }}">
    @endauth

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <style>
        /*
         * Blood Link design tokens
         * ------------------------
         * Signature idea: the ECG / pulse waveform — the one visual motif
         * unique to this brand — appears exactly twice (navbar mark, hero
         * divider) and nowhere else. Everything surrounding it stays quiet:
         * a clinical paper background, a restrained crimson, and a single
         * warm serif reserved for headlines only.
         */
        :root {
            --bl-primary: #C81E3A;      /* Crimson Pulse — brand, primary actions */
            --bl-primary-rgb: 200, 30, 58;
            --bl-danger: #B0233B;
            --bl-danger-rgb: 176, 35, 59;
            --bl-ink: #1B1B1F;           /* body text */
            --bl-ink-rgb: 27, 27, 31;
            --bl-paper: #FBF7F4;         /* background — warm clinical paper */
            --bl-surface: #FFFFFF;
            --bl-pulse: #2C8C7C;         /* teal — success / available / active */
            --bl-pulse-rgb: 44, 140, 124;
            --bl-gold: #B8892B;          /* warning / badges */
            --bl-gold-rgb: 184, 137, 43;
            --bl-info: #3B6EA5;
            --bl-info-rgb: 59, 110, 165;
            --bl-slate: #6B6F76;         /* secondary text, borders */
            --bl-slate-rgb: 107, 111, 118;
            --bl-line: #E9E2DC;

            /* Re-point Bootstrap's own variables so every existing
               btn-primary / bg-danger / badge utility across the app
               picks up the palette without touching each view. */
            --bs-primary: var(--bl-primary);
            --bs-primary-rgb: var(--bl-primary-rgb);
            --bs-danger: var(--bl-danger);
            --bs-danger-rgb: var(--bl-danger-rgb);
            --bs-success: var(--bl-pulse);
            --bs-success-rgb: var(--bl-pulse-rgb);
            --bs-warning: var(--bl-gold);
            --bs-warning-rgb: var(--bl-gold-rgb);
            --bs-info: var(--bl-info);
            --bs-info-rgb: var(--bl-info-rgb);
            --bs-secondary: var(--bl-slate);
            --bs-secondary-rgb: var(--bl-slate-rgb);
            --bs-body-bg: var(--bl-paper);
            --bs-body-color: var(--bl-ink);
            --bs-border-radius: .55rem;
            --bs-border-radius-lg: .8rem;
            --bs-border-radius-sm: .4rem;
            --bs-font-sans-serif: 'Inter', system-ui, -apple-system, sans-serif;
            --bs-link-color: var(--bl-primary);
            --bs-link-hover-color: var(--bl-danger);
            --bs-border-color: var(--bl-line);
        }

        body { background: var(--bl-paper); color: var(--bl-ink); }

        h1, h2, h3, .display-headline {
            font-family: 'Fraunces', Georgia, serif;
            letter-spacing: -0.01em;
        }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }

        .navbar { background: var(--bl-surface) !important; border-bottom: 1px solid var(--bl-line); }
        .navbar-brand { font-family: 'Fraunces', Georgia, serif; font-weight: 600; font-size: 1.2rem; color: var(--bl-ink) !important; }
        .navbar-brand .pulse-mark { color: var(--bl-primary); display: inline-flex; }
        .navbar-brand .pulse-mark svg { width: 26px; height: 18px; }
        .navbar-brand .pulse-mark path { stroke-dasharray: 60; stroke-dashoffset: 60; animation: draw-pulse 2.2s ease-in-out infinite; }

        @keyframes draw-pulse {
            0% { stroke-dashoffset: 60; }
            35% { stroke-dashoffset: 0; }
            100% { stroke-dashoffset: 0; }
        }
        @media (prefers-reduced-motion: reduce) {
            .navbar-brand .pulse-mark path { animation: none; stroke-dashoffset: 0; }
            .hero-pulse path { animation: none !important; stroke-dashoffset: 0 !important; }
        }

        .sidebar { min-height: calc(100vh - 57px); background: var(--bl-surface); border-right: 1px solid var(--bl-line); }
        .sidebar .nav-link { color: var(--bl-ink); border-radius: .5rem; font-size: .925rem; }
        .sidebar .nav-link i { width: 1.25rem; color: var(--bl-slate); }
        .sidebar .nav-link.active { color: var(--bl-primary); background: rgba(var(--bl-primary-rgb), .08); font-weight: 600; }
        .sidebar .nav-link.active i { color: var(--bl-primary); }
        .sidebar .nav-link:hover:not(.active) { background: rgba(var(--bl-ink-rgb), .04); }

        .card { border: 1px solid var(--bl-line); border-radius: var(--bs-border-radius-lg); box-shadow: 0 1px 2px rgba(27,27,31,.04); }
        .btn { font-weight: 500; }
        .btn-primary { background: var(--bl-primary); border-color: var(--bl-primary); }
        .btn-primary:hover, .btn-primary:focus { background: var(--bl-danger); border-color: var(--bl-danger); }
        .btn-outline-primary { color: var(--bl-primary); border-color: var(--bl-primary); }
        .btn-outline-primary:hover { background: var(--bl-primary); border-color: var(--bl-primary); }

        .badge-bronze { background: #9C6B3E; color: #fff; }
        .badge-silver { background: #8A8F98; color: #fff; }
        .badge-gold   { background: var(--bl-gold); color: #fff; }
        .badge-platinum { background: var(--bl-ink); color: #fff; }

        /* Notification bell */
        #notifBell { position: relative; }
        #notifBadge {
            position: absolute; top: -6px; right: -8px;
            background: var(--bl-primary); color: #fff; border-radius: 999px;
            font-size: .65rem; padding: 1px 5px; font-family: 'IBM Plex Mono', monospace;
            display: none;
        }
        #notifBell.has-unread #notifBadge { display: inline-block; }
        @keyframes bell-ring {
            0%, 100% { transform: rotate(0); }
            15% { transform: rotate(14deg); }
            30% { transform: rotate(-12deg); }
            45% { transform: rotate(8deg); }
            60% { transform: rotate(-6deg); }
            75% { transform: rotate(2deg); }
        }
        #notifBell.ringing i { animation: bell-ring .6s ease-in-out; display: inline-block; transform-origin: top center; }

        /* Signature pulse divider — used sparingly, once per page at most */
        .pulse-divider { width: 100%; height: 28px; opacity: .8; }
        .pulse-divider path { stroke: var(--bl-primary); }

        @stack('styles')
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        @auth
            <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i>
            </button>
        @endauth
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="pulse-mark">
                <svg viewBox="0 0 60 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 12 H16 L21 3 L28 21 L33 12 H60" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            Blood Link
        </a>
        <div class="d-flex align-items-center ms-auto gap-3">
            @auth
                <a href="{{ route('notifications.index') }}" id="notifBell" class="text-dark fs-5 text-decoration-none">
                    <i class="bi bi-bell"></i>
                    <span id="notifBadge">0</span>
                </a>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Become a Donor</a>
            @endauth
        </div>
    </div>
</nav>

@auth
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <h6 class="offcanvas-title">Menu</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        @include('partials.sidebar')
    </div>
</div>
@endauth

<div class="container-fluid">
    <div class="row">
        @auth
            <div class="col-lg-2 sidebar py-3 d-none d-lg-block">
                @include('partials.sidebar')
            </div>
            <div class="col-lg-10 py-4">
                @include('partials.alerts')
                @yield('content')
            </div>
        @else
            <div class="col-12 py-4">
                @include('partials.alerts')
                @yield('content')
            </div>
        @endauth
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

@auth
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
    // ── Real-time transport (Laravel Reverb, Pusher protocol) ──────────
    window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const currentUserId = document.querySelector('meta[name="current-user-id"]')?.content;
    const reverbMeta = (name) => document.querySelector(`meta[name="${name}"]`)?.content;

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: reverbMeta('reverb-key'),
        wsHost: reverbMeta('reverb-host'),
        wsPort: reverbMeta('reverb-port'),
        wssPort: reverbMeta('reverb-port'),
        forceTLS: reverbMeta('reverb-scheme') === 'https',
        enabledTransports: ['ws', 'wss'],
        auth: { headers: { 'X-CSRF-TOKEN': window.csrfToken } },
    });

    // ── Notification chime (Web Audio — no external asset needed) ──────
    function playNotificationChime() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            [880, 1320].forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.value = freq;
                gain.gain.setValueAtTime(0.0001, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.15, ctx.currentTime + i * 0.12 + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + i * 0.12 + 0.35);
                osc.connect(gain).connect(ctx.destination);
                osc.start(ctx.currentTime + i * 0.12);
                osc.stop(ctx.currentTime + i * 0.12 + 0.4);
            });
        } catch (e) { /* Web Audio unsupported — fail silently */ }
    }

    // ── Live notification bell ──────────────────────────────────────────
    const notifBell = document.getElementById('notifBell');
    const notifBadge = document.getElementById('notifBadge');
    let unreadCount = parseInt(notifBadge?.textContent || '0', 10);

    function refreshBadge() {
        if (!notifBadge) return;
        notifBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
        notifBell.classList.toggle('has-unread', unreadCount > 0);
    }

    async function loadUnreadCount() {
        try {
            const res = await fetch('/notifications/unread-count');
            const data = await res.json();
            unreadCount = data.count ?? 0;
            refreshBadge();
        } catch (e) { /* ignore */ }
    }
    loadUnreadCount();

    if (currentUserId) {
        Echo.private(`user.${currentUserId}`).listen('.notification.created', (payload) => {
            unreadCount += 1;
            refreshBadge();
            playNotificationChime();
            notifBell.classList.add('ringing');
            setTimeout(() => notifBell.classList.remove('ringing'), 650);

            Swal.fire({
                toast: true, position: 'top-end', icon: 'info',
                title: payload.title, text: payload.message,
                timer: 4500, showConfirmButton: false,
            });
        });
    }

    @if (session('success'))
        Swal.fire({ icon: 'success', title: @json(session('success')), timer: 2500, showConfirmButton: false });
    @endif
    @if ($errors->any())
        Swal.fire({ icon: 'error', title: 'Something needs your attention', text: @json($errors->first()) });
    @endif
</script>
@else
<script>
    window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    @if (session('success'))
        Swal.fire({ icon: 'success', title: @json(session('success')), timer: 2500, showConfirmButton: false });
    @endif
    @if ($errors->any())
        Swal.fire({ icon: 'error', title: 'Something needs your attention', text: @json($errors->first()) });
    @endif
</script>
@endauth
@stack('scripts')
</body>
</html>
