@extends('layouts.app')
@section('title', 'Conversation')

@section('content')
<a href="{{ route('admin.chats.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back</a>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card p-3">
            <div class="text-muted small">Donor</div>
            <div class="fw-bold">{{ $session->donor->user->name }}</div>
            <div class="small text-muted">{{ $session->donor->bloodGroup->name ?? '' }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="text-muted small">Patient</div>
            <div class="fw-bold">{{ $session->patient->user->name }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="text-muted small">Session</div>
            <div class="fw-bold">{{ $session->status }}</div>
            <div class="small text-muted">
                Started {{ $session->started_at->format('d M Y, h:i A') }}
                @if ($session->ended_at) &middot; Ended {{ $session->ended_at->format('d M Y, h:i A') }} @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><i class="bi bi-eye"></i> Read-only — administrators cannot send messages</div>
    <div class="card-body" id="adminChatBody" style="max-height: 500px; overflow-y: auto;">
        @forelse ($session->chatMessages as $message)
            <div class="d-flex mb-2 {{ $message->sender_id === $session->donor->user_id ? 'justify-content-start' : 'justify-content-end' }}">
                <div class="p-2 rounded-3 bg-light" style="max-width: 65%;">
                    <div class="small fw-bold">{{ $message->sender_id === $session->donor->user_id ? $session->donor->user->name : $session->patient->user->name }}</div>
                    <div>{{ $message->message }}</div>
                    <div class="small text-muted">{{ $message->created_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center mb-0" id="adminChatEmpty">No messages exchanged yet.</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    const donorUserId = {{ $session->donor->user_id }};
    const donorName = @json($session->donor->user->name);
    const patientName = @json($session->patient->user->name);
    const adminChatBody = document.getElementById('adminChatBody');

    // Live view only — the admin never sends, just watches messages arrive.
    Echo.private(`donation-session.{{ $session->id }}`).listen('.message.sent', (m) => {
        document.getElementById('adminChatEmpty')?.remove();
        const fromDonor = m.sender_id === donorUserId;
        const div = document.createElement('div');
        div.className = `d-flex mb-2 ${fromDonor ? 'justify-content-start' : 'justify-content-end'}`;
        div.innerHTML = `<div class="p-2 rounded-3 bg-light" style="max-width:65%;">
            <div class="small fw-bold">${fromDonor ? donorName : patientName}</div>
            <div>${m.message}</div>
            <div class="small text-muted">${m.created_at_human ?? ''}</div>
        </div>`;
        adminChatBody.appendChild(div);
        adminChatBody.scrollTop = adminChatBody.scrollHeight;
    });
</script>
@endpush
@endsection
