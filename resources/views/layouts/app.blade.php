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
         * Blood Link Design System v2.0
         * A refined, professional aesthetic for modern blood bank management
         */
        
        /* ── Design Tokens ── */
        :root {
            --bl-crimson: #C41E3A;
            --bl-crimson-rgb: 196, 30, 58;
            --bl-crimson-dark: #A01830;
            --bl-crimson-light: #FDE8EC;
            
            --bl-teal: #2A9D8F;
            --bl-teal-rgb: 42, 157, 143;
            --bl-teal-light: #E6F4F2;
            
            --bl-gold: #E9B741;
            --bl-gold-rgb: 233, 183, 65;
            --bl-gold-light: #FDF5E6;
            
            --bl-ink: #1A1A1E;
            --bl-ink-rgb: 26, 26, 30;
            --bl-slate: #6B7280;
            --bl-slate-rgb: 107, 114, 128;
            --bl-paper: #F8F6F3;
            --bl-surface: #FFFFFF;
            --bl-border: #E8E4E0;
            
            /* Bootstrap overrides */
            --bs-primary: var(--bl-crimson);
            --bs-primary-rgb: var(--bl-crimson-rgb);
            --bs-success: var(--bl-teal);
            --bs-success-rgb: var(--bl-teal-rgb);
            --bs-warning: var(--bl-gold);
            --bs-warning-rgb: var(--bl-gold-rgb);
            --bs-secondary: var(--bl-slate);
            --bs-secondary-rgb: var(--bl-slate-rgb);
            --bs-body-bg: var(--bl-paper);
            --bs-body-color: var(--bl-ink);
            --bs-border-color: var(--bl-border);
            --bs-border-radius: 0.75rem;
            --bs-border-radius-lg: 1rem;
            --bs-border-radius-sm: 0.5rem;
            --bs-font-sans-serif: 'Inter', system-ui, -apple-system, sans-serif;
            --bs-link-color: var(--bl-crimson);
            --bs-link-hover-color: var(--bl-crimson-dark);
            
            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.10);
            --shadow-xl: 0 16px 48px rgba(0,0,0,0.12);
        }

        /* ── Base Styles ── */
        * { box-sizing: border-box; }
        
        body {
            background: var(--bl-paper);
            color: var(--bl-ink);
            font-family: 'Inter', -apple-system, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1, h2, h3, h4, h5, .display-headline {
            font-family: 'Fraunces', Georgia, serif;
            letter-spacing: -0.02em;
            font-weight: 600;
        }

        .font-mono { font-family: 'IBM Plex Mono', monospace; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--bl-border); border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--bl-slate); }

        /* ── Navbar ── */
        .navbar {
            background: rgba(255,255,255,0.92) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(232, 228, 224, 0.5);
            padding: 0.75rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        .navbar-brand {
            font-family: 'Fraunces', Georgia, serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--bl-ink) !important;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .navbar-brand .pulse-mark {
            color: var(--bl-crimson);
            display: inline-flex;
            align-items: center;
        }

        .navbar-brand .pulse-mark svg {
            width: 28px;
            height: 20px;
        }

        .navbar-brand .pulse-mark path {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: draw-pulse 2.4s ease-in-out infinite;
            stroke-width: 2.5;
        }

        @keyframes draw-pulse {
            0% { stroke-dashoffset: 60; }
            30% { stroke-dashoffset: 0; }
            100% { stroke-dashoffset: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            .navbar-brand .pulse-mark path { animation: none; stroke-dashoffset: 0; }
            .hero-pulse path { animation: none !important; stroke-dashoffset: 0 !important; }
        }

        .navbar .nav-link {
            color: var(--bl-ink);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .navbar .nav-link:hover {
            background: rgba(var(--bl-crimson-rgb), 0.06);
            color: var(--bl-crimson);
        }

        .navbar .nav-link.active {
            background: rgba(var(--bl-crimson-rgb), 0.10);
            color: var(--bl-crimson);
        }

        /* ── Sidebar ── */
        .sidebar {
            min-height: calc(100vh - 65px);
            background: var(--bl-surface);
            border-right: 1px solid var(--bl-border);
            padding: 1.5rem 0.75rem;
            position: sticky;
            top: 65px;
            height: calc(100vh - 65px);
            overflow-y: auto;
        }

        .sidebar .sidebar-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--bl-slate);
            padding: 0.5rem 1rem 0.25rem;
            opacity: 0.6;
        }

        .sidebar .nav-link {
            color: var(--bl-ink);
            border-radius: 0.625rem;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.625rem 1rem;
            margin-bottom: 0.125rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar .nav-link i {
            width: 1.25rem;
            font-size: 1.1rem;
            color: var(--bl-slate);
            transition: color 0.2s ease;
        }

        .sidebar .nav-link:hover:not(.active) {
            background: rgba(var(--bl-ink-rgb), 0.04);
            color: var(--bl-ink);
        }

        .sidebar .nav-link:hover:not(.active) i {
            color: var(--bl-ink);
        }

        .sidebar .nav-link.active {
            background: rgba(var(--bl-crimson-rgb), 0.08);
            color: var(--bl-crimson);
            font-weight: 600;
        }

        .sidebar .nav-link.active i {
            color: var(--bl-crimson);
        }

        /* ── Cards ── */
        .card {
            border: 1px solid var(--bl-border);
            border-radius: var(--bs-border-radius-lg);
            background: var(--bl-surface);
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.25s ease, transform 0.2s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--bl-border);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid var(--bl-border);
            padding: 1rem 1.5rem;
        }

        /* ── Buttons ── */
        .btn {
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5625rem 1.25rem;
            border-radius: 0.625rem;
            transition: all 0.2s ease;
            letter-spacing: 0.01em;
        }

        .btn-primary {
            background: var(--bl-crimson);
            border-color: var(--bl-crimson);
            color: #fff;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--bl-crimson-dark);
            border-color: var(--bl-crimson-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(var(--bl-crimson-rgb), 0.30);
        }

        .btn-outline-primary {
            color: var(--bl-crimson);
            border-color: var(--bl-crimson);
        }

        .btn-outline-primary:hover {
            background: var(--bl-crimson);
            border-color: var(--bl-crimson);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(var(--bl-crimson-rgb), 0.25);
        }

        .btn-success {
            background: var(--bl-teal);
            border-color: var(--bl-teal);
        }

        .btn-success:hover {
            background: #228B7F;
            border-color: #228B7F;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(var(--bl-teal-rgb), 0.30);
        }

        .btn-outline-secondary {
            color: var(--bl-slate);
            border-color: var(--bl-border);
        }

        .btn-outline-secondary:hover {
            background: var(--bl-paper);
            border-color: var(--bl-slate);
            color: var(--bl-ink);
        }

        .btn-sm {
            padding: 0.375rem 0.875rem;
            font-size: 0.8rem;
        }

        /* ── Badges ── */
        .badge {
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 999px;
            letter-spacing: 0.01em;
            font-size: 0.7rem;
        }

        .badge-bronze { background: #CD7F32; color: #fff; }
        .badge-silver { background: #A8AAB3; color: #fff; }
        .badge-gold { background: var(--bl-gold); color: #fff; }
        .badge-platinum { background: #2C2C34; color: #fff; }

        /* ── Notification Bell ── */
        #notifBell {
            position: relative;
            color: var(--bl-ink);
            text-decoration: none;
            font-size: 1.3rem;
            padding: 0.25rem;
            border-radius: 999px;
            transition: background 0.2s ease;
        }

        #notifBell:hover {
            background: rgba(var(--bl-ink-rgb), 0.05);
        }

        #notifBadge {
            position: absolute;
            top: -4px;
            right: -6px;
            background: var(--bl-crimson);
            color: #fff;
            border-radius: 999px;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 2px 6px;
            min-width: 18px;
            text-align: center;
            font-family: 'IBM Plex Mono', monospace;
            display: none;
            border: 2px solid #fff;
            box-shadow: var(--shadow-sm);
        }

        #notifBell.has-unread #notifBadge {
            display: inline-block;
        }

        @keyframes bell-ring {
            0%, 100% { transform: rotate(0); }
            15% { transform: rotate(16deg); }
            30% { transform: rotate(-14deg); }
            45% { transform: rotate(10deg); }
            60% { transform: rotate(-8deg); }
            75% { transform: rotate(4deg); }
        }

        #notifBell.ringing i {
            animation: bell-ring 0.6s ease-in-out;
            display: inline-block;
            transform-origin: top center;
        }

        /* ── Pulse Divider ── */
        .pulse-divider {
            width: 100%;
            height: 32px;
            opacity: 0.6;
        }

        .pulse-divider path {
            stroke: var(--bl-crimson);
            stroke-width: 2.5;
        }

        /* ── Alerts ── */
        .alert {
            border: none;
            border-radius: var(--bs-border-radius);
            padding: 1rem 1.25rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: var(--bl-teal-light);
            color: #1A6B5F;
        }

        .alert-danger {
            background: #FDE8EC;
            color: #A01830;
        }

        .alert-warning {
            background: var(--bl-gold-light);
            color: #9C7A2E;
        }

        /* ── Dropdown ── */
        .dropdown-menu {
            border: 1px solid var(--bl-border);
            border-radius: var(--bs-border-radius);
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.5rem 0.875rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: background 0.15s ease;
        }

        .dropdown-item:hover {
            background: rgba(var(--bl-ink-rgb), 0.04);
        }

        .dropdown-item:active {
            background: rgba(var(--bl-crimson-rgb), 0.08);
            color: var(--bl-crimson);
        }

        /* ── Utilities ── */
        .bg-crimson-light { background: var(--bl-crimson-light); }
        .bg-teal-light { background: var(--bl-teal-light); }
        .bg-gold-light { background: var(--bl-gold-light); }

        .text-crimson { color: var(--bl-crimson); }
        .text-teal { color: var(--bl-teal); }
        .text-gold { color: var(--bl-gold); }

        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 1rem; }
        .gap-4 { gap: 1.5rem; }

        .rounded-4 { border-radius: 1rem; }
        .rounded-5 { border-radius: 1.25rem; }

        .border-dashed { border-style: dashed !important; }

        /* ── Responsive Tweaks ── */
        @media (max-width: 991.98px) {
            .navbar { padding: 0.5rem 1rem; }
            .sidebar { display: none; }
        }

        @media (max-width: 575.98px) {
            .navbar-brand { font-size: 1rem; }
            .navbar-brand .pulse-mark svg { width: 22px; height: 16px; }
            .card-body { padding: 1.25rem; }
            .btn { padding: 0.5rem 1rem; font-size: 0.8rem; }
        }

        /* ── Stack injection ── */
        @stack('styles')
    </style>
</head>
<body>

<!-- ─── NAVBAR ─── -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid px-lg-4">
        @auth
            <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i>
            </button>
        @endauth

        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="pulse-mark">
                <svg viewBox="0 0 60 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 12 H16 L21 3 L28 21 L33 12 H60" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            Blood Link
        </a>

        <div class="d-flex align-items-center ms-auto gap-3">
            @auth
                <a href="{{ route('notifications.index') }}" id="notifBell" class="text-decoration-none" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span id="notifBadge">0</span>
                </a>

                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
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

<!-- ─── MOBILE SIDEBAR ─── -->
@auth
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title fw-bold">Menu</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        @include('partials.sidebar')
    </div>
</div>
@endauth

<!-- ─── MAIN CONTENT ─── -->
<div class="container-fluid px-lg-4">
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

<!-- ─── SCRIPTS ─── -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

@auth
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
    // ── Real-time transport ──
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

    // ── Notification chime ──
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

    // ── Live notification bell ──
    const notifBell = document.getElementById('notifBell');
    const notifBadge = document.getElementById('notifBadge');
    let unreadCount = parseInt(notifBadge?.textContent || '0', 10);

    function refreshBadge() {
        if (!notifBadge) return;
        notifBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
        notifBell?.classList.toggle('has-unread', unreadCount > 0);
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
            notifBell?.classList.add('ringing');
            setTimeout(() => notifBell?.classList.remove('ringing'), 650);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: payload.title || 'New Notification',
                text: payload.message,
                timer: 4500,
                showConfirmButton: false,
                background: '#FFFFFF',
                boxShadow: '0 8px 32px rgba(0,0,0,0.12)',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        });
    }

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: @json(session('success')),
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#FFFFFF',
            boxShadow: '0 8px 32px rgba(0,0,0,0.10)',
            customClass: { popup: 'rounded-4' }
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Something needs your attention',
            text: @json($errors->first()),
            confirmButtonColor: '#C41E3A',
            confirmButtonText: 'Got it',
            customClass: { popup: 'rounded-4' }
        });
    @endif
</script>
@else
<script>
    window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: @json(session('success')),
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#FFFFFF',
            boxShadow: '0 8px 32px rgba(0,0,0,0.10)',
            customClass: { popup: 'rounded-4' }
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Something needs your attention',
            text: @json($errors->first()),
            confirmButtonColor: '#C41E3A',
            confirmButtonText: 'Got it',
            customClass: { popup: 'rounded-4' }
        });
    @endif
</script>
@endauth

@stack('scripts')
</body>
</html>