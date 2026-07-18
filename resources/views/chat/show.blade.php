@extends('layouts.app')
@section('title', 'Chat')

@section('content')
@php
    $me = auth()->user();
    $isDonorSide = $me->id === $session->donor->user_id;
    $other = $isDonorSide ? $session->patient->user : $session->donor->user;
@endphp

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between bg-white">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-3 text-secondary"></i>
            <div>
                <div class="fw-bold">{{ $other->name }}</div>
                <div class="small text-muted">
                    {{ $session->donor->bloodGroup->name ?? '' }} &middot;
                    <span id="sessionStatus">{{ $session->status }}</span>
                </div>
            </div>
        </div>
        <div class="text-end">
            @if ($session->status === 'Active')
                <div class="small text-muted">Time remaining</div>
                <div class="fw-bold" id="sessionTimer" data-expires="{{ $session->expires_at->toIso8601String() }}">--:--</div>
            @endif
        </div>
    </div>

    <div class="card-body" style="height: 420px; overflow-y: auto;" id="chatBody">
        @foreach ($session->chatMessages as $message)
            <div class="d-flex mb-2 {{ $message->sender_id === $me->id ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-2 rounded-3 {{ $message->sender_id === $me->id ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 70%;">
                    <div>{{ $message->message }}</div>
                    <div class="small {{ $message->sender_id === $me->id ? 'text-white-50' : 'text-muted' }}">
                        {{ $message->created_at->format('h:i A') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card-footer bg-white">
        @if ($session->status === 'Active')
            <form id="chatForm" class="d-flex gap-2 mb-2">
                @csrf
                <input type="text" name="message" id="messageInput" class="form-control" placeholder="Type a message..." maxlength="1000" required>
                <button class="btn btn-primary"><i class="bi bi-send"></i></button>
            </form>

            <div class="d-flex flex-wrap gap-2">
                @if ($isDonorSide)
                    @if (! $session->contact_shared)
                        <form action="{{ route('donor.sessions.share-contact', $session) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-secondary btn-sm">Share Contact Details</button>
                        </form>
                    @endif
                    <form action="{{ route('donor.sessions.complete', $session) }}" method="POST" onsubmit="return confirm('Mark this donation as completed?');">
                        @csrf @method('PATCH')
                        <button class="btn btn-success btn-sm">Complete Donation</button>
                    </form>
                    <form action="{{ route('donor.sessions.end', $session) }}" method="POST" onsubmit="return confirm('End this session without completing a donation?');">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger btn-sm">End Session</button>
                    </form>
                @endif
            </div>

            @if ($session->contact_shared && ! $isDonorSide)
                <div class="alert alert-info mt-2 mb-0 py-2">
                    <i class="bi bi-telephone"></i> {{ $session->donor->user->phone }} &middot;
                    <i class="bi bi-envelope"></i> {{ $session->donor->user->email }}
                </div>
            @endif
        @else
            <div class="text-muted text-center">This chat session is {{ strtolower($session->status) }}.</div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const sessionId = {{ $session->id }};
    const meId = {{ $me->id }};
    const chatBody = document.getElementById('chatBody');

    chatBody.scrollTop = chatBody.scrollHeight;

    function appendMessage(m) {
        const mine = m.sender_id === meId;
        const div = document.createElement('div');
        div.className = `d-flex mb-2 ${mine ? 'justify-content-end' : 'justify-content-start'}`;
        div.innerHTML = `<div class="p-2 rounded-3 ${mine ? 'bg-primary text-white' : 'bg-light'}" style="max-width:70%;">
            <div>${m.message}</div>
            <div class="small ${mine ? 'text-white-50' : 'text-muted'}">${m.created_at_human ?? ''}</div>
        </div>`;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // ── Real-time delivery: Reverb/Echo, no polling and no page reload ──
    Echo.private(`donation-session.${sessionId}`).listen('.message.sent', (payload) => {
        if (payload.sender_id !== meId) {
            appendMessage(payload);
        }
    });

    const form = document.getElementById('chatForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const input = document.getElementById('messageInput');
            const text = input.value.trim();
            if (!text) return;

            // Render locally right away, then send — the broadcast excludes
            // this tab (toOthers), so there's no duplicate on our own screen.
            const optimistic = { sender_id: meId, message: text, created_at_human: 'Sending…' };
            appendMessage(optimistic);
            input.value = '';

            await fetch(`/chat/${sessionId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json',
                    'X-Socket-ID': Echo.socketId(),
                },
                body: JSON.stringify({ message: text }),
            });
        });
    }

    const timerEl = document.getElementById('sessionTimer');
    if (timerEl) {
        const expiresAt = new Date(timerEl.dataset.expires).getTime();
        setInterval(() => {
            const diff = Math.max(0, expiresAt - Date.now());
            const mins = String(Math.floor(diff / 60000)).padStart(2, '0');
            const secs = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            timerEl.textContent = `${mins}:${secs}`;
        }, 1000);
    }
</script>
@endpush
@endsection
