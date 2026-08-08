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

    <!-- ── Bootstrap 5 + Icons ── -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- ── Fonts ── -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144;500;9..144;600;9..144;700&family=Inter:wght@300;400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════════════════
           Blood Link · Modern Medical Design System
           Clean, trustworthy, and life-affirming.
           ═══════════════════════════════════════════════════════════ */

         :root {
             /* Core palette — medical red, trust blue, healing teal */
             --bl-primary:    #DC2626;          /* Medical Red — actions, accents */
             --bl-primary-rgb: 220, 38, 38;
             --bl-secondary:  #2563EB;          /* Trust Blue — nav, charts */
             --bl-secondary-rgb: 37, 99, 235;

             --bl-success:    #10B981;          /* Healing teal */
             --bl-success-rgb: 16, 185, 129;
             --bl-info:       #3B82F6;
             --bl-info-rgb:   59, 130, 246;
             --bl-warning:    #F59E0B;
             --bl-warning-rgb: 245, 158, 11;
             --bl-danger:     #EA580C;          /* Coral-red for danger */

             /* Neutrals */
             --bl-ink:        #1E293B;          /* primary text */
             --bl-ink-rgb:    30, 41, 59;
             --bl-paper:      #F0F4F8;          /* page background */
             --bl-surface:    #FFFFFF;          /* card / page surface */
             --bl-elev:       #FFFFFF;          /* elevated surface (cards) */
             --bl-slate:      #64748B;          /* secondary text, borders */
             --bl-slate-rgb:  100, 116, 140;
             --bl-line:       #E2E8F0;

             /* Gradients */
             --bl-hero-gradient: 135deg, #DC2626 0%, #EA580C 55%, #F59E0B 100%;

             /* Re-point Bootstrap */
             --bs-primary:        var(--bl-primary);
             --bs-primary-rgb:    var(--bl-primary-rgb);
             --bs-secondary:      var(--bl-secondary);
             --bs-secondary-rgb:  var(--bl-secondary-rgb);
             --bs-success:        var(--bl-success);
             --bs-success-rgb:    var(--bl-success-rgb);
             --bs-info:           var(--bl-info);
             --bs-info-rgb:       var(--bl-info-rgb);
             --bs-warning:        var(--bl-warning);
             --bs-warning-rgb:    var(--bl-warning-rgb);
             --bs-danger:         var(--bl-danger);
             --bs-danger-rgb:     234, 88, 12;
             --bs-body-bg:        var(--bl-paper);
             --bs-body-color:     var(--bl-ink);
             --bs-border-radius:    .65rem;
             --bs-border-radius-lg: .9rem;
             --bs-border-radius-sm: .4rem;
             --bs-font-sans-serif:  'Inter', system-ui, -apple-system, sans-serif;
             --bs-link-color:       var(--bl-primary);
             --bs-link-hover-color: var(--bl-danger);
             --bs-border-color:     var(--bl-line);
         }

         /* ── Base / background ── */
         body {
             background: var(--bl-paper);
             color: var(--bl-ink);
             font-weight: 400;
         }
         h1, h2, h3, h4, h5, h6, .display-headline {
             font-family: 'Fraunces', Georgia, serif;
             font-weight: 600;
             letter-spacing: -0.008em;
         }
         .font-mono { font-family: 'IBM Plex Mono', monospace; }
         a { color: var(--bl-primary); }
         a:hover { color: var(--bl-danger); }

         /* ── Main content area ── */
         .page-wrapper { min-height: calc(100vh - 57px); }

         /* ── Navbar ── */
         .navbar {
             background: var(--bl-surface) !important;
             border-bottom: 1px solid var(--bl-line);
             box-shadow: 0 1px 3px rgba(30,41,59,.05);
         }
         .navbar-brand {
             font-family: 'Fraunces', Georgia, serif;
             font-weight: 600; font-size: 1.25rem; color: var(--bl-ink) !important;
         }
         .navbar-brand .pulse-mark { color: var(--bl-primary); display: inline-flex; }
         .navbar-brand .pulse-mark svg { width: 28px; height: 20px; }
         .navbar-brand .pulse-mark path {
             stroke-dasharray: 60; stroke-dashoffset: 60;
             animation: draw-pulse 2.4s ease-in-out infinite;
         }
         @keyframes draw-pulse {
             0% { stroke-dashoffset: 60; }
             35% { stroke-dashoffset: 0; }
             100% { stroke-dashoffset: 0; }
         }
         @media (prefers-reduced-motion: reduce) {
             .navbar-brand .pulse-mark path { animation: none; stroke-dashoffset: 0; }
         }

         /* ── Sidebar / Nav ── */
         .sidebar {
             min-height: calc(100vh - 57px);
             background: var(--bl-surface);
             border-right: 1px solid var(--bl-line);
         }
         .sidebar .nav-link {
             color: var(--bl-ink);
             border-radius: .55rem;
             font-size: .9rem;
             font-weight: 500;
             padding: .6rem 1rem;
             margin-bottom: .2rem;
             transition: all .16s ease;
         }
         .sidebar .nav-link i { width: 1.25rem; color: var(--bl-slate); margin-right: .5rem; }
         .sidebar .nav-link.active {
             color: var(--bl-primary);
             background: rgba(var(--bl-primary-rgb), .08);
         }
         .sidebar .nav-link.active i { color: var(--bl-primary); }
         .sidebar .nav-link:hover:not(.active) {
             background: rgba(var(--bl-ink-rgb), .04);
             color: var(--bl-secondary);
         }

         /* ── Cards ── modern, floating */
         .card {
             border: 1px solid var(--bl-line);
             border-radius: var(--bs-border-radius-lg);
             box-shadow: 0 1px 3px rgba(30,41,59,.05);
             background: var(--bl-surface);
         }
         .card-header {
             background: rgba(248,250,252,.8);
             border-bottom: 1px solid var(--bl-line);
             font-family: 'Fraunces', Georgia, serif;
             font-weight: 600;
         }
         .card-body { padding: 1.5rem; }

         /* ── Stats cards (home/dashboard) ── */
         .stat-card {
             border: 1px solid var(--bl-line);
             border-radius: var(--bs-border-radius-lg);
             padding: 1.25rem 1rem;
             text-align: center;
             background: var(--bl-surface);
             box-shadow: 0 1px 3px rgba(30,41,59,.05);
             transition: transform .16s ease, box-shadow .16s ease;
         }
         .stat-card:hover {
             transform: translateY(-2px);
             box-shadow: 0 6px 14px rgba(30,41,59,.08);
         }
         .stat-card .stat-value {
             font-size: 1.9rem;
             font-weight: 700;
             font-family: 'IBM Plex Mono', monospace;
         }
         .stat-card .stat-label {
             font-size: .8rem;
             text-transform: uppercase;
             letter-spacing: .04em;
             color: var(--bl-slate);
         }

         /* ── Buttons ── */
         .btn {
             font-weight: 500;
             border-radius: var(--bs-border-radius);
             transition: transform .08s ease, box-shadow .16s ease;
         }
         .btn-sm { font-size: .85rem; }
         .btn-primary {
             background: var(--bl-primary);
             border-color: var(--bl-primary);
             box-shadow: 0 2px 6px rgba(var(--bl-primary-rgb), .22);
         }
         .btn-primary:hover, .btn-primary:focus {
             background: var(--bl-danger);
             border-color: var(--bl-danger);
             box-shadow: 0 4px 12px rgba(var(--bl-primary-rgb), .30);
             transform: translateY(-1px);
         }
         .btn-outline-primary {
             color: var(--bl-primary);
             border-color: var(--bl-primary);
         }
         .btn-outline-primary:hover {
             background: var(--bl-primary);
             color: #fff;
         }
         .btn-secondary, .btn-outline-secondary {
             background: var(--bl-surface);
             border-color: var(--bl-line);
             color: var(--bl-ink);
         }
         .btn-secondary:hover, .btn-outline-secondary:hover {
             background: var(--bl-paper);
             border-color: var(--bl-slate);
         }
         .btn-success { background: var(--bl-success); border-color: var(--bl-success); }
         .btn-warning { color: #fff; }

         /* ── Forms ── */
         .form-control, .form-select {
             border-radius: var(--bs-border-radius);
             border: 1.5px solid var(--bl-line);
             padding-left: .85rem;
             transition: border-color .16s ease, box-shadow .16s ease;
         }
         .form-control:focus, .form-select:focus {
             border-color: var(--bl-secondary);
             box-shadow: 0 0 0 3px rgba(var(--bl-secondary-rgb), .16);
         }
         .form-label {
             font-weight: 500;
             color: var(--bl-ink);
             margin-bottom: .25rem;
         }

         /* ── Password field with eye toggle ── */
         .password-field { position: relative; }
         .password-field .form-control { padding-right: 2.75rem; }
         .password-toggle {
             position: absolute;
             right: .6rem;
             top: 50%;
             transform: translateY(-50%);
             border: none;
             background: transparent;
             color: var(--bl-slate);
             cursor: pointer;
             padding: .3rem;
             line-height: 1;
             transition: color .16s ease;
         }
         .password-toggle:hover { color: var(--bl-primary); }
         .password-toggle:focus { outline: 2px solid var(--bl-secondary); outline-offset: 1px; border-radius: 4px; }

         /* ── Hero section ── */
         .hero-section {
             background: var(--bl-surface);
             border: 1px solid var(--bl-line);
             border-radius: var(--bs-border-radius-lg);
             padding: 2.5rem 2rem;
             box-shadow: 0 4px 20px rgba(30,41,59,.06);
         }
         .hero-badge {
             display: inline-block;
             padding: .3rem .8rem;
             border-radius: 999px;
             background: rgba(var(--bl-primary-rgb), .08);
             color: var(--bl-primary);
             font-size: .78rem;
             font-weight: 600;
             letter-spacing: .05em;
             text-transform: uppercase;
         }

         /* ── Pulse divider (signature motif) ── */
         .pulse-divider { width: 100%; height: 32px; opacity: .85; }
         .pulse-divider path { stroke: var(--bl-primary); }

         /* ── Notification bell ── */
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

         /* ── Badges ── */
         .badge-bronze { background: #9C6B3E; color: #fff; }
         .badge-silver { background: #8A8F98; color: #fff; }
         .badge-gold   { background: var(--bl-gold); color: #fff; }
         .badge-platinum { background: var(--bl-ink); color: #fff; }

         /* ── Tables ── */
         .table-hover tbody tr:hover { background: rgba(var(--bl-secondary-rgb), .04); }
         .table thead th {
             border: none;
             font-weight: 600;
             color: var(--bl-slate);
             font-size: .8rem;
             text-transform: uppercase;
             letter-spacing: .03em;
         }
         .table td, .table th { vertical-align: middle; }

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
                        @if (auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.mail.create') }}">Compose Mail</a></li>
                        @endif
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

<main class="container-fluid page-wrapper">
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
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

@auth
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
    // ── Real-time transport (Laravel Reverb, Pusher protocol) ──────
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

    // ── Notification chime (from public/audio/) ──────────────────────
    const NOTIF_SOUND = '/audio/mixkit-positive-notification-951.wav';
    const notifAudio = new Audio(NOTIF_SOUND);
    function playNotificationChime() {
        try {
            notifAudio.currentTime = 0;
            notifAudio.play().catch(() => {}); /* autoplay may be blocked */
        } catch (e) { /* fail silently */ }
    }

    // ── Live notification bell ───────────────────────────────────────
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
</script>
@endauth

<script>
    window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
</script>

<!-- ── Password eye-toggle ── runs on every page ────────────────────── -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.password-field').forEach(function (field) {
        const input  = field.querySelector('input[type="password"], input[type="text"]');
        const toggle = field.querySelector('.password-toggle');
        const icon   = toggle?.querySelector('i');
        if (!input || !toggle || !icon) return;
        toggle.addEventListener('click', function () {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('bi-eye-slash');
            icon.classList.toggle('bi-eye');
        });
    });

    @if (session('success'))
        Swal.fire({ icon: 'success', title: @json(session('success')), timer: 2500, showConfirmButton: false });
    @endif
    @if ($errors->any())
        Swal.fire({ icon: 'error', title: 'Something needs your attention', text: @json($errors->first()) });
    @endif
});
</script>

@stack('scripts')
</body>
</html>
