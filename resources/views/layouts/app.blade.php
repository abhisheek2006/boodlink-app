<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Blood Link') - Smart Blood Bank</title>

    @auth
        <meta name="reverb-key"
            content="{{ config('broadcasting.connections.reverb.key') }}">

        <meta name="reverb-host"
            content="{{ config('broadcasting.connections.reverb.options.host') }}">

        <meta name="reverb-port"
            content="{{ config('broadcasting.connections.reverb.options.port') }}">

        <meta name="reverb-scheme"
            content="{{ config('broadcasting.connections.reverb.options.scheme') }}">

        <meta name="current-user-id"
            content="{{ auth()->id() }}">
    @endauth

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">


    <style>

        /* =========================================================
           BLOOD LINK DESIGN SYSTEM
        ========================================================= */

        :root {

            --bl-primary: #DC2626;
            --bl-primary-dark: #B91C1C;
            --bl-primary-light: #FEF2F2;

            --bl-blue: #2563EB;
            --bl-blue-light: #EFF6FF;

            --bl-success: #16A34A;
            --bl-warning: #F59E0B;
            --bl-danger: #DC2626;

            --bl-dark: #172033;
            --bl-text: #334155;
            --bl-muted: #64748B;

            --bl-bg: #F6F8FB;
            --bl-white: #FFFFFF;

            --bl-border: #E5E7EB;

            --bl-radius: 14px;

            --bs-primary: var(--bl-primary);
            --bs-primary-rgb: 220, 38, 38;

            --bs-body-bg: var(--bl-bg);
            --bs-body-color: var(--bl-text);

            --bs-border-color: var(--bl-border);

            --bs-font-sans-serif:
                'Inter',
                system-ui,
                -apple-system,
                sans-serif;
        }


        /* =========================================================
           GLOBAL
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bl-bg);
            color: var(--bl-text);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Fraunces', Georgia, serif;
            color: var(--bl-dark);
            font-weight: 600;
        }

        a {
            color: var(--bl-primary);
            text-decoration: none;
        }

        a:hover {
            color: var(--bl-primary-dark);
        }


        /* =========================================================
           NAVBAR
        ========================================================= */

        .navbar {
            height: 64px;
            background: rgba(255, 255, 255, .96) !important;
            border-bottom: 1px solid var(--bl-border);
            box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
            z-index: 1030;
        }

        .navbar-brand {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--bl-dark) !important;
            letter-spacing: -.02em;
        }

        .navbar-brand:hover {
            color: var(--bl-dark) !important;
        }


        /* Heart / pulse logo */

        .pulse-mark {
            width: 32px;
            height: 32px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: var(--bl-primary-light);
            color: var(--bl-primary);
        }

        .pulse-mark svg {
            width: 25px;
            height: 20px;
        }

        .pulse-mark path {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;

            animation:
                draw-pulse 2.4s ease-in-out infinite;
        }

        @keyframes draw-pulse {

            0% {
                stroke-dashoffset: 60;
            }

            35% {
                stroke-dashoffset: 0;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .pulse-mark path {
                animation: none;
                stroke-dashoffset: 0;
            }
        }


        /* =========================================================
           NAVBAR USER AREA
        ========================================================= */

        .navbar .dropdown-toggle {
            border-radius: 10px;
            padding: 7px 12px;
            font-weight: 500;
        }

        .navbar .dropdown-toggle::after {
            margin-left: 8px;
        }

        .navbar .dropdown-menu {
            margin-top: 10px;
            border: 1px solid var(--bl-border);
            border-radius: 12px;
            padding: 7px;
            box-shadow:
                0 10px 30px rgba(15, 23, 42, .10);
        }

        .navbar .dropdown-item {
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
        }

        .navbar .dropdown-item:hover {
            background: var(--bl-primary-light);
            color: var(--bl-primary);
        }


        /* =========================================================
           NOTIFICATION BELL
        ========================================================= */

        #notifBell {
            position: relative;

            width: 38px;
            height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            color: var(--bl-dark) !important;

            transition: .2s ease;
        }

        #notifBell:hover {
            background: var(--bl-primary-light);
            color: var(--bl-primary) !important;
        }

        #notifBadge {
            position: absolute;

            top: -2px;
            right: -2px;

            min-width: 17px;
            height: 17px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 4px;

            border-radius: 50px;

            background: var(--bl-primary);
            color: white;

            font-size: 9px;
            font-weight: 700;

            border: 2px solid white;

            display: none;
        }

        #notifBell.has-unread #notifBadge {
            display: flex;
        }


        @keyframes bell-ring {

            0%,
            100% {
                transform: rotate(0);
            }

            15% {
                transform: rotate(14deg);
            }

            30% {
                transform: rotate(-12deg);
            }

            45% {
                transform: rotate(8deg);
            }

            60% {
                transform: rotate(-6deg);
            }

            75% {
                transform: rotate(2deg);
            }
        }

        #notifBell.ringing i {
            animation: bell-ring .6s ease-in-out;
            transform-origin: top center;
        }


        /* =========================================================
           MAIN LAYOUT
        ========================================================= */

        .page-wrapper {
            min-height: calc(100vh - 64px);
        }

        .sidebar {
            min-height: calc(100vh - 64px);

            background: var(--bl-white);

            border-right: 1px solid var(--bl-border);

            padding: 18px 14px !important;
        }


        /* =========================================================
           SIDEBAR NAVIGATION
        ========================================================= */

        .sidebar .nav {
            gap: 3px !important;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 10px 12px;

            border-radius: 10px;

            color: #475569;

            font-size: 13px;
            font-weight: 500;

            transition:
                background .18s ease,
                color .18s ease,
                transform .18s ease;
        }

        .sidebar .nav-link i {
            width: 20px;

            color: #94A3B8;

            font-size: 16px;

            text-align: center;

            transition: color .18s ease;
        }

        .sidebar .nav-link:hover {
            background: #F8FAFC;

            color: var(--bl-primary);

            transform: translateX(2px);
        }

        .sidebar .nav-link:hover i {
            color: var(--bl-primary);
        }

        .sidebar .nav-link.active {
            background: var(--bl-primary-light);

            color: var(--bl-primary);

            font-weight: 600;
        }

        .sidebar .nav-link.active i {
            color: var(--bl-primary);
        }


        /* =========================================================
           MOBILE SIDEBAR
        ========================================================= */

        .offcanvas {
            width: 280px !important;

            border: 0;

            box-shadow:
                10px 0 35px rgba(15, 23, 42, .12);
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--bl-border);
        }

        .offcanvas-title {
            font-family: 'Fraunces', Georgia, serif;
            font-weight: 600;
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        main > .row > .col-lg-10 {
            padding-left: 28px !important;
            padding-right: 28px !important;
        }


        /* =========================================================
           CARDS
        ========================================================= */

        .card {
            border: 1px solid var(--bl-border);

            border-radius: var(--bl-radius);

            background: var(--bl-white);

            box-shadow:
                0 2px 8px rgba(15, 23, 42, .035);

            overflow: hidden;
        }

        .card-header {
            background: #FAFBFC;

            border-bottom: 1px solid var(--bl-border);

            padding: 15px 18px;

            color: var(--bl-dark);

            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }


        /* =========================================================
           BUTTONS
        ========================================================= */

        .btn {
            border-radius: 9px;

            font-weight: 500;

            transition:
                transform .15s ease,
                box-shadow .15s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--bl-primary);
            border-color: var(--bl-primary);

            box-shadow:
                0 3px 8px rgba(220, 38, 38, .20);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--bl-primary-dark);
            border-color: var(--bl-primary-dark);

            box-shadow:
                0 5px 14px rgba(220, 38, 38, .25);
        }

        .btn-outline-primary {
            color: var(--bl-primary);
            border-color: var(--bl-primary);
        }

        .btn-outline-primary:hover {
            background: var(--bl-primary);
            border-color: var(--bl-primary);
            color: white;
        }

        .btn-outline-secondary {
            color: #475569;
            border-color: var(--bl-border);
            background: white;
        }

        .btn-outline-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            color: var(--bl-dark);
        }

        .btn-success {
            background: var(--bl-success);
            border-color: var(--bl-success);
        }


        /* =========================================================
           FORMS
        ========================================================= */

        .form-label {
            color: var(--bl-dark);

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            min-height: 40px;

            border: 1px solid var(--bl-border);

            border-radius: 9px;

            color: var(--bl-dark);

            background: white;

            transition:
                border-color .15s ease,
                box-shadow .15s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--bl-primary);

            box-shadow:
                0 0 0 3px rgba(220, 38, 38, .10);
        }

        .form-control::placeholder {
            color: #94A3B8;
        }


        /* =========================================================
           PASSWORD FIELD
        ========================================================= */

        .password-field {
            position: relative;
        }

        .password-field .form-control {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;

            right: 10px;
            top: 50%;

            transform: translateY(-50%);

            border: 0;

            background: transparent;

            color: #94A3B8;

            cursor: pointer;

            padding: 5px;

            line-height: 1;
        }

        .password-toggle:hover {
            color: var(--bl-primary);
        }


        /* =========================================================
           TABLES
        ========================================================= */

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #F8FAFC;

            border-bottom: 1px solid var(--bl-border);

            color: #64748B;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: .04em;

            text-transform: uppercase;

            padding: 13px 15px;
        }

        .table tbody td {
            padding: 14px 15px;

            border-color: #F1F5F9;

            color: #334155;
        }

        .table-hover tbody tr:hover {
            background: #FAFBFC;
        }


        /* =========================================================
           BADGES
        ========================================================= */

        .badge {
            border-radius: 6px;

            font-size: 11px;

            font-weight: 600;

            padding: 5px 8px;
        }

        .badge-bronze {
            background: #9C6B3E;
            color: white;
        }

        .badge-silver {
            background: #8A8F98;
            color: white;
        }

        .badge-gold {
            background: #D4A017;
            color: white;
        }

        .badge-platinum {
            background: #172033;
            color: white;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {
            border-radius: 10px;
            border: 0;
        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination {
            gap: 5px;
        }

        .pagination .page-link {
            border: 1px solid var(--bl-border);

            border-radius: 8px !important;

            color: #475569;

            background: white;

            min-width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 13px;

            box-shadow: none;
        }

        .pagination .page-link:hover {
            background: var(--bl-primary-light);

            color: var(--bl-primary);

            border-color: #FECACA;
        }

        .pagination .active .page-link {
            background: var(--bl-primary);

            border-color: var(--bl-primary);

            color: white;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991.98px) {

            main > .row > .col-lg-10 {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .sidebar {
                display: none;
            }

        }


        @media (max-width: 575.98px) {

            .navbar {
                height: 58px;
            }

            .navbar-brand {
                font-size: 1.15rem;
            }

            .pulse-mark {
                width: 29px;
                height: 29px;
            }

            main > .row > .col-lg-10,
            main > .row > .col-12 {
                padding: 16px !important;
            }

            .card-body {
                padding: 16px;
            }

        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }

        }


        @stack('styles')

    </style>

</head>


<body>


<!-- =========================================================
     NAVBAR
========================================================= -->

<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container-fluid px-3 px-lg-4">

        @auth

            <button
                class="btn btn-sm btn-outline-secondary d-lg-none me-2"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar">

                <i class="bi bi-list fs-5"></i>

            </button>

        @endauth


        <!-- Brand -->

        <a
            class="navbar-brand d-flex align-items-center gap-2"
            href="{{ route('home') }}">

            <span class="pulse-mark">

                <svg
                    viewBox="0 0 60 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">

                    <path
                        d="M0 12 H16 L21 3 L28 21 L33 12 H60"
                        stroke="currentColor"
                        stroke-width="2.4"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>

                </svg>

            </span>

            Blood Link

        </a>


        <!-- Right side -->

        <div class="d-flex align-items-center ms-auto gap-2 gap-md-3">

            @auth

                <!-- Notification -->

                <a
                    href="{{ route('notifications.index') }}"
                    id="notifBell"
                    aria-label="Notifications">

                    <i class="bi bi-bell"></i>

                    <span id="notifBadge">0</span>

                </a>


                <!-- User -->

                <div class="dropdown">

                    <button
                        class="btn btn-sm btn-outline-secondary dropdown-toggle"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-person-circle me-1"></i>

                        <span class="d-none d-sm-inline">
                            {{ auth()->user()->name }}
                        </span>

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('profile.edit') }}">

                                <i class="bi bi-person me-2"></i>
                                Edit Profile

                            </a>
                        </li>


                        @if (auth()->user()->isAdmin())

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.mail.create') }}">

                                    <i class="bi bi-envelope me-2"></i>
                                    Compose Mail

                                </a>

                            </li>

                        @endif


                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>

                            <form
                                action="{{ route('logout') }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item">

                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout

                                </button>

                            </form>

                        </li>

                    </ul>

                </div>


            @else


                <a
                    href="{{ route('login') }}"
                    class="btn btn-outline-secondary btn-sm">

                    Login

                </a>


                <a
                    href="{{ route('register') }}"
                    class="btn btn-primary btn-sm">

                    <i class="bi bi-heart-pulse me-1"></i>

                    <span class="d-none d-sm-inline">
                        Become a Donor
                    </span>

                </a>


            @endauth

        </div>

    </div>

</nav>



<!-- =========================================================
     MOBILE SIDEBAR
========================================================= -->

@auth

<div
    class="offcanvas offcanvas-start"
    tabindex="-1"
    id="mobileSidebar">

    <div class="offcanvas-header">

        <div class="d-flex align-items-center gap-2">

            <span class="pulse-mark">

                <svg
                    viewBox="0 0 60 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">

                    <path
                        d="M0 12 H16 L21 3 L28 21 L33 12 H60"
                        stroke="currentColor"
                        stroke-width="2.4"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>

                </svg>

            </span>

            <h6 class="offcanvas-title mb-0">
                Blood Link
            </h6>

        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>

    </div>


    <div class="offcanvas-body">

        @include('partials.sidebar')

    </div>

</div>

@endauth



<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<main class="container-fluid page-wrapper">

    <div class="row">

        @auth

            <!-- Desktop Sidebar -->

            <div class="col-lg-2 sidebar d-none d-lg-block">

                @include('partials.sidebar')

            </div>


            <!-- Content -->

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



<!-- =========================================================
     BOOTSTRAP
========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<!-- =========================================================
     SWEET ALERT
========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</script>



@auth

<!-- =========================================================
     REAL-TIME CHAT / NOTIFICATIONS
========================================================= -->

<script
    src="https://js.pusher.com/8.4.0/pusher.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js">
</script>


<script>

    window.csrfToken =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).content;


    const currentUserId =
        document.querySelector(
            'meta[name="current-user-id"]'
        )?.content;


    const reverbMeta = (name) => {

        return document.querySelector(
            `meta[name="${name}"]`
        )?.content;

    };


    /* Echo */

    window.Echo = new Echo({

        broadcaster: 'reverb',

        key:
            reverbMeta('reverb-key'),

        wsHost:
            reverbMeta('reverb-host'),

        wsPort:
            reverbMeta('reverb-port'),

        wssPort:
            reverbMeta('reverb-port'),

        forceTLS:
            reverbMeta('reverb-scheme') === 'https',

        enabledTransports:
            ['ws', 'wss'],

        auth: {

            headers: {

                'X-CSRF-TOKEN':
                    window.csrfToken

            }

        }

    });


    /* =====================================================
       Notification Sound
    ===================================================== */

    const notifAudio =
        new Audio(
            '/audio/mixkit-positive-notification-951.wav'
        );


    function playNotificationChime() {

        try {

            notifAudio.currentTime = 0;

            notifAudio
                .play()
                .catch(() => {});

        } catch (error) {

            // Ignore audio errors

        }

    }


    /* =====================================================
       Notification Badge
    ===================================================== */

    const notifBell =
        document.getElementById('notifBell');

    const notifBadge =
        document.getElementById('notifBadge');


    let unreadCount =
        parseInt(
            notifBadge?.textContent || '0',
            10
        );


    function refreshBadge() {

        if (!notifBadge || !notifBell) {
            return;
        }


        notifBadge.textContent =
            unreadCount > 99
                ? '99+'
                : unreadCount;


        notifBell.classList.toggle(
            'has-unread',
            unreadCount > 0
        );

    }


    /* =====================================================
       Load unread notifications
    ===================================================== */

    async function loadUnreadCount() {

        try {

            const response =
                await fetch(
                    '/notifications/unread-count'
                );


            const data =
                await response.json();


            unreadCount =
                data.count ?? 0;


            refreshBadge();

        } catch (error) {

            // Ignore notification request errors

        }

    }


    loadUnreadCount();


    /* =====================================================
       Live notifications
    ===================================================== */

    if (currentUserId && notifBell) {

        Echo
            .private(`user.${currentUserId}`)
            .listen(
                '.notification.created',
                function (payload) {

                    unreadCount++;

                    refreshBadge();

                    playNotificationChime();


                    notifBell.classList.add(
                        'ringing'
                    );


                    setTimeout(
                        function () {

                            notifBell.classList.remove(
                                'ringing'
                            );

                        },
                        650
                    );


                    Swal.fire({

                        toast: true,

                        position: 'top-end',

                        icon: 'info',

                        title:
                            payload.title,

                        text:
                            payload.message,

                        timer: 4500,

                        showConfirmButton: false

                    });

                }
            );

    }

</script>

@endauth



<!-- =========================================================
     PASSWORD TOGGLE + GLOBAL ALERTS
========================================================= -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* Password visibility */

        document
            .querySelectorAll('.password-field')
            .forEach(function (field) {


                const input =
                    field.querySelector(
                        'input[type="password"], input[type="text"]'
                    );


                const toggle =
                    field.querySelector(
                        '.password-toggle'
                    );


                const icon =
                    toggle?.querySelector('i');


                if (!input || !toggle || !icon) {
                    return;
                }


                toggle.addEventListener(
                    'click',
                    function () {


                        const isPassword =
                            input.getAttribute(
                                'type'
                            ) === 'password';


                        input.setAttribute(
                            'type',
                            isPassword
                                ? 'text'
                                : 'password'
                        );


                        icon.classList.toggle(
                            'bi-eye-slash',
                            !isPassword
                        );


                        icon.classList.toggle(
                            'bi-eye',
                            isPassword
                        );

                    }
                );

            });



        /* Success message */

        @if (session('success'))

            Swal.fire({

                icon: 'success',

                title:
                    @json(session('success')),

                timer: 2500,

                showConfirmButton: false

            });

        @endif



        /* Validation error */

        @if ($errors->any())

            Swal.fire({

                icon: 'error',

                title:
                    'Something needs your attention',

                text:
                    @json($errors->first())

            });

        @endif

    }
);

</script>



@stack('scripts')

</body>
</html>