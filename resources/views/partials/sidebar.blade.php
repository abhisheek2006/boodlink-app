@php $user = auth()->user(); @endphp

<ul class="nav nav-pills flex-column gap-1">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('*.dashboard') ? 'active' : '' }}"
           href="{{ route($user->dashboardRoute()) }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>

    @if ($user->isAdmin())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> User Management</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.mail.*') ? 'active' : '' }}" href="{{ route('admin.mail.index') }}"><i class="bi bi-envelope-paper"></i> Mail Composer</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.blood-groups.*') ? 'active' : '' }}" href="{{ route('admin.blood-groups.index') }}"><i class="bi bi-droplet"></i> Blood Groups</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.blood-stocks.*') ? 'active' : '' }}" href="{{ route('admin.blood-stocks.index') }}"><i class="bi bi-boxes"></i> Blood Inventory</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.blood-requests.*') ? 'active' : '' }}" href="{{ route('admin.blood-requests.index') }}"><i class="bi bi-card-list"></i> Blood Requests</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}" href="{{ route('admin.donations.index') }}"><i class="bi bi-heart-pulse"></i> Donations</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}" href="{{ route('admin.chats.index') }}"><i class="bi bi-chat-dots"></i> Chat Monitoring</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}" href="{{ route('admin.audit-logs.index') }}"><i class="bi bi-shield-check"></i> Audit Log</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear"></i> System Settings</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Reports</a></li>
    @endif

    @if ($user->isDonor())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('donor.requests.*') ? 'active' : '' }}" href="{{ route('donor.requests.index') }}"><i class="bi bi-envelope"></i> Blood Requests</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('donor.history') ? 'active' : '' }}" href="{{ route('donor.history') }}"><i class="bi bi-clock-history"></i> Donation History</a></li>
    @endif

    @if ($user->isPatient())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('patient.search') ? 'active' : '' }}" href="{{ route('patient.search') }}"><i class="bi bi-search"></i> Search Donors</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('patient.requests.*') ? 'active' : '' }}" href="{{ route('patient.requests.index') }}"><i class="bi bi-card-list"></i> My Requests</a></li>
    @endif

    @unless ($user->isAdmin())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}"><i class="bi bi-trophy"></i> Leaderboard</a></li>
    @endunless

    <li class="nav-item"><a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}"><i class="bi bi-bell"></i> Notifications</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="bi bi-gear"></i> Settings</a></li>
</ul>
