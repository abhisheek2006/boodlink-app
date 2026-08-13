@php
    $user = auth()->user();
@endphp

<style>
    .bl-sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .bl-sidebar-section {
        margin: 14px 10px 6px;
        color: #9aa3b2;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .bl-sidebar-nav .nav-item {
        width: 100%;
    }

    .bl-sidebar-nav .nav-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 13px;
        border-radius: 10px;
        color: #687386;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all .2s ease;
    }

    .bl-sidebar-nav .nav-link i {
        width: 20px;
        min-width: 20px;
        text-align: center;
        font-size: 17px;
        transition: all .2s ease;
    }

    .bl-sidebar-nav .nav-link:hover {
        background: #f8f9fb;
        color: #172033;
    }

    .bl-sidebar-nav .nav-link:hover i {
        color: #ef233c;
    }

    .bl-sidebar-nav .nav-link.active {
        background: #fff0f1;
        color: #d91e36;
        font-weight: 600;
    }

    .bl-sidebar-nav .nav-link.active i {
        color: #ef233c;
    }

    .bl-sidebar-nav .nav-link.active::before {
        content: "";
        position: absolute;
        left: -1px;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 22px;
        border-radius: 0 4px 4px 0;
        background: #ef233c;
    }

    .bl-sidebar-divider {
        height: 1px;
        margin: 12px 8px;
        background: #edf0f4;
    }

    .bl-nav-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .bl-sidebar-nav .nav-link {
            padding: 11px 14px;
        }
    }
</style>


<nav class="bl-sidebar-nav">

    {{-- Main --}}
    <div class="bl-sidebar-section">
        Main
    </div>

    <div class="nav-item">
        <a
            class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('*.dashboard') ? 'active' : '' }}"
            href="{{ route($user->dashboardRoute()) }}"
        >
            <span class="bl-nav-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </span>
            <span>Dashboard</span>
        </a>
    </div>


    {{-- Admin Navigation --}}
    @if ($user->isAdmin())

        <div class="bl-sidebar-section">
            Administration
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                href="{{ route('admin.users.index') }}"
            >
                <i class="bi bi-people"></i>
                <span>User Management</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.mail.*') ? 'active' : '' }}"
                href="{{ route('admin.mail.index') }}"
            >
                <i class="bi bi-envelope-paper"></i>
                <span>Mail Composer</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.blood-groups.*') ? 'active' : '' }}"
                href="{{ route('admin.blood-groups.index') }}"
            >
                <i class="bi bi-droplet"></i>
                <span>Blood Groups</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.blood-stocks.*') ? 'active' : '' }}"
                href="{{ route('admin.blood-stocks.index') }}"
            >
                <i class="bi bi-box-seam"></i>
                <span>Blood Inventory</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.blood-requests.*') ? 'active' : '' }}"
                href="{{ route('admin.blood-requests.index') }}"
            >
                <i class="bi bi-card-list"></i>
                <span>Blood Requests</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}"
                href="{{ route('admin.donations.index') }}"
            >
                <i class="bi bi-heart-pulse"></i>
                <span>Donations</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}"
                href="{{ route('admin.chats.index') }}"
            >
                <i class="bi bi-chat-dots"></i>
                <span>Chat Monitoring</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}"
                href="{{ route('admin.audit-logs.index') }}"
            >
                <i class="bi bi-shield-check"></i>
                <span>Audit Log</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                href="{{ route('admin.settings.index') }}"
            >
                <i class="bi bi-sliders"></i>
                <span>System Settings</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                href="{{ route('admin.reports.index') }}"
            >
                <i class="bi bi-bar-chart"></i>
                <span>Reports</span>
            </a>
        </div>

    @endif


    {{-- Donor Navigation --}}
    @if ($user->isDonor())

        <div class="bl-sidebar-section">
            Donor
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('donor.requests.*') ? 'active' : '' }}"
                href="{{ route('donor.requests.index') }}"
            >
                <i class="bi bi-envelope-heart"></i>
                <span>Blood Requests</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('donor.history') ? 'active' : '' }}"
                href="{{ route('donor.history') }}"
            >
                <i class="bi bi-clock-history"></i>
                <span>Donation History</span>
            </a>
        </div>

    @endif


    {{-- Patient Navigation --}}
    @if ($user->isPatient())

        <div class="bl-sidebar-section">
            Patient
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('patient.search') ? 'active' : '' }}"
                href="{{ route('patient.search') }}"
            >
                <i class="bi bi-search"></i>
                <span>Search Donors</span>
            </a>
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('patient.requests.*') ? 'active' : '' }}"
                href="{{ route('patient.requests.index') }}"
            >
                <i class="bi bi-card-list"></i>
                <span>My Requests</span>
            </a>
        </div>

    @endif


    {{-- Community --}}
    @unless ($user->isAdmin())

        <div class="bl-sidebar-section">
            Community
        </div>

        <div class="nav-item">
            <a
                class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}"
                href="{{ route('leaderboard') }}"
            >
                <i class="bi bi-trophy"></i>
                <span>Leaderboard</span>
            </a>
        </div>

    @endunless


    {{-- Account --}}
    <div class="bl-sidebar-section">
        Account
    </div>

    <div class="nav-item">
        <a
            class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
            href="{{ route('notifications.index') }}"
        >
            <i class="bi bi-bell"></i>
            <span>Notifications</span>
        </a>
    </div>

    <div class="nav-item">
        <a
            class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
            href="{{ route('profile.edit') }}"
        >
            <i class="bi bi-person-gear"></i>
            <span>Settings</span>
        </a>
    </div>

</nav>