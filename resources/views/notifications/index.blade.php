@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-bell"></i> Notifications</h4>
    <form action="{{ route('notifications.read-all') }}" method="POST">
        @csrf @method('PATCH')
        <button class="btn btn-sm btn-outline-secondary">Mark all as read</button>
    </form>
</div>

<div class="list-group">
    @forelse ($notifications as $notification)
        <div class="list-group-item d-flex justify-content-between align-items-start {{ $notification->is_read ? '' : 'bg-light' }}">
            <div>
                <div class="fw-bold">
                    @unless ($notification->is_read)<span class="badge bg-danger me-1">New</span>@endunless
                    {{ $notification->title }}
                </div>
                <div class="text-muted">{{ $notification->message }}</div>
                <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
            <div class="d-flex gap-1">
                @unless ($notification->is_read)
                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-secondary" title="Mark as read"><i class="bi bi-check2"></i></button>
                    </form>
                @endunless
                <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Delete this notification?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-muted text-center py-4 mb-0">No notifications yet.</p>
    @endforelse
</div>

<div class="mt-3">{{ $notifications->links() }}</div>
@endsection
