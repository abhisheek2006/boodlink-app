@extends('layouts.app')
@section('title', 'Chat')

@section('content')

@php
    $me = auth()->user();
    $isDonorSide = $me->id === $session->donor->user_id;
    $other = $isDonorSide
        ? $session->patient->user
        : $session->donor->user;
@endphp

<style>
    .chat-page {
        max-width: 1180px;
        margin: 0 auto;
    }

    .chat-header-card {
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(25, 42, 70, 0.06);
        overflow: hidden;
    }

    .chat-header {
        padding: 22px 26px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #edf0f4;
    }

    .chat-user {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .chat-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0f1;
        color: #ef233c;
        font-size: 24px;
        flex-shrink: 0;
    }

    .chat-user-name {
        font-size: 18px;
        font-weight: 700;
        color: #14213d;
        margin-bottom: 3px;
    }

    .chat-user-info {
        color: #718096;
        font-size: 13px;
    }

    .chat-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: 6px;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #16b77a;
        display: inline-block;
    }

    .timer-box {
        min-width: 110px;
        padding: 9px 15px;
        text-align: center;
        background: #fff5f5;
        border: 1px solid #ffd7d9;
        border-radius: 12px;
    }

    .timer-label {
        display: block;
        font-size: 11px;
        color: #8a94a6;
        margin-bottom: 2px;
    }

    .timer-value {
        color: #e5232e;
        font-size: 19px;
        font-weight: 700;
    }

    .chat-body {
        height: 500px;
        overflow-y: auto;
        padding: 28px;
        background: #fbfcfe;
    }

    .chat-body::-webkit-scrollbar {
        width: 7px;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background: #dce1e8;
        border-radius: 10px;
    }

    .message-row {
        display: flex;
        margin-bottom: 18px;
        align-items: flex-end;
        gap: 9px;
    }

    .message-row.mine {
        justify-content: flex-end;
    }

    .message-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff0f1;
        color: #ef233c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .message-row.mine .message-avatar {
        background: #eaf1ff;
        color: #2874e8;
        order: 2;
    }

    .message-bubble {
        max-width: 68%;
        padding: 12px 15px 9px;
        border-radius: 17px 17px 17px 5px;
        background: #fff;
        border: 1px solid #edf0f4;
        box-shadow: 0 3px 10px rgba(20, 33, 61, 0.04);
    }

    .message-row.mine .message-bubble {
        border-radius: 17px 17px 5px 17px;
        background: #ef233c;
        color: #fff;
        border-color: #ef233c;
    }

    .message-text {
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
    }

    .message-time {
        margin-top: 5px;
        font-size: 10px;
        color: #9aa3b2;
    }

    .message-row.mine .message-time {
        color: rgba(255,255,255,.72);
    }

    .chat-footer {
        background: #fff;
        padding: 18px 22px 20px;
        border-top: 1px solid #edf0f4;
    }

    .chat-input-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f7f8fa;
        border: 1px solid #e5e9ef;
        border-radius: 14px;
        padding: 5px;
    }

    .chat-input {
        border: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 11px 13px;
        font-size: 14px;
    }

    .chat-input:focus {
        outline: none;
    }

    .send-btn {
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 11px;
        background: #ef233c;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s ease;
    }

    .send-btn:hover {
        background: #d91f35;
        transform: translateY(-1px);
    }

    .chat-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 13px;
    }

    .chat-action {
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        padding: 8px 13px;
    }

    .contact-alert {
        margin-top: 13px;
        margin-bottom: 0;
        border: 0;
        border-radius: 11px;
        background: #eef8ff;
        color: #31506d;
        padding: 11px 14px;
        font-size: 13px;
    }

    .inactive-chat {
        text-align: center;
        padding: 13px;
        background: #f8f9fb;
        border-radius: 10px;
        color: #7a8494;
        font-size: 13px;
    }

    .empty-chat {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9aa3b2;
    }

    .empty-chat-icon {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        background: #fff0f1;
        color: #ef233c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {

        .chat-header {
            padding: 17px;
        }

        .chat-body {
            height: 430px;
            padding: 18px 14px;
        }

        .chat-footer {
            padding: 14px;
        }

        .timer-box {
            min-width: 88px;
        }

        .message-bubble {
            max-width: 82%;
        }

        .chat-user-name {
            font-size: 16px;
        }

        .chat-user-info {
            font-size: 11px;
        }
    }
</style>


<div class="chat-page">

    {{-- Chat Card --}}
    <div class="chat-header-card">

        {{-- Header --}}
        <div class="chat-header">

            <div class="chat-user">

                <div class="chat-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>

                    <div class="chat-user-name">
                        {{ $other->name }}
                    </div>

                    <div class="chat-user-info">

                        <span>
                            <i class="bi bi-droplet-fill text-danger me-1"></i>
                            {{ $session->donor->bloodGroup->name ?? 'Blood Group N/A' }}
                        </span>

                        <span class="chat-status">

                            @if ($session->status === 'Active')
                                <span class="status-dot"></span>
                            @endif

                            {{ $session->status }}

                        </span>

                    </div>

                </div>

            </div>


            {{-- Timer --}}
            @if ($session->status === 'Active')

                <div class="timer-box">

                    <span class="timer-label">
                        Time Remaining
                    </span>

                    <span
                        class="timer-value"
                        id="sessionTimer"
                        data-expires="{{ $session->expires_at->toIso8601String() }}"
                    >
                        --:--
                    </span>

                </div>

            @endif

        </div>


        {{-- Chat Messages --}}
        <div
            class="chat-body"
            id="chatBody"
        >

            @forelse ($session->chatMessages as $message)

                @php
                    $mine = $message->sender_id === $me->id;
                @endphp

                <div class="message-row {{ $mine ? 'mine' : '' }}">

                    <div class="message-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="message-bubble">

                        <div class="message-text">
                            {{ $message->message }}
                        </div>

                        <div class="message-time">
                            {{ $message->created_at->format('h:i A') }}
                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-chat">

                    <div class="empty-chat-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>

                    <div class="fw-semibold">
                        No messages yet
                    </div>

                    <div class="small">
                        Start the conversation below.
                    </div>

                </div>

            @endforelse

        </div>


        {{-- Footer --}}
        <div class="chat-footer">

            @if ($session->status === 'Active')

                {{-- Message Input --}}
                <form
                    id="chatForm"
                    class="mb-0"
                >

                    @csrf

                    <div class="chat-input-wrapper">

                        <input
                            type="text"
                            name="message"
                            id="messageInput"
                            class="form-control chat-input"
                            placeholder="Type a message..."
                            maxlength="1000"
                            autocomplete="off"
                            required
                        >

                        <button
                            type="submit"
                            class="send-btn"
                            aria-label="Send message"
                        >
                            <i class="bi bi-send-fill"></i>
                        </button>

                    </div>

                </form>


                {{-- Actions --}}
                <div class="chat-actions">

                    @if ($isDonorSide)

                        @if (! $session->contact_shared)

                            <form
                                action="{{ route('donor.sessions.share-contact', $session) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    class="btn btn-outline-secondary chat-action"
                                    type="submit"
                                >
                                    <i class="bi bi-person-vcard me-1"></i>
                                    Share Contact
                                </button>

                            </form>

                        @endif


                        <form
                            action="{{ route('donor.sessions.complete', $session) }}"
                            method="POST"
                            onsubmit="return confirm('Mark this donation as completed?');"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                class="btn btn-success chat-action"
                                type="submit"
                            >
                                <i class="bi bi-check-circle me-1"></i>
                                Complete Donation
                            </button>

                        </form>


                        <form
                            action="{{ route('donor.sessions.end', $session) }}"
                            method="POST"
                            onsubmit="return confirm('End this session without completing a donation?');"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                class="btn btn-outline-danger chat-action"
                                type="submit"
                            >
                                <i class="bi bi-x-circle me-1"></i>
                                End Session
                            </button>

                        </form>

                    @endif

                </div>


                {{-- Shared Contact --}}
                @if ($session->contact_shared && ! $isDonorSide)

                    <div class="contact-alert">

                        <i class="bi bi-person-check-fill text-success me-1"></i>

                        <strong>Donor contact details:</strong>

                        <span class="ms-2">
                            <i class="bi bi-telephone me-1"></i>
                            {{ $session->donor->user->phone }}
                        </span>

                        <span class="ms-2">
                            <i class="bi bi-envelope me-1"></i>
                            {{ $session->donor->user->email }}
                        </span>

                    </div>

                @endif

            @else

                <div class="inactive-chat">

                    <i class="bi bi-info-circle me-1"></i>

                    This chat session is
                    <strong>{{ strtolower($session->status) }}</strong>.

                </div>

            @endif

        </div>

    </div>

</div>


@push('scripts')

<script>

    const sessionId = {{ $session->id }};
    const meId = {{ $me->id }};
    const chatBody = document.getElementById('chatBody');

    chatBody.scrollTop = chatBody.scrollHeight;


    /*
    |--------------------------------------------------------------------------
    | Append Message
    |--------------------------------------------------------------------------
    */

    function appendMessage(m) {

        const mine = m.sender_id === meId;

        const div = document.createElement('div');

        div.className = `message-row ${mine ? 'mine' : ''}`;

        div.innerHTML = `
            <div class="message-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="message-bubble">

                <div class="message-text">
                    ${escapeHtml(m.message)}
                </div>

                <div class="message-time">
                    ${m.created_at_human || formatTime(m.created_at) || ''}
                </div>

            </div>
        `;

        chatBody.appendChild(div);

        chatBody.scrollTop = chatBody.scrollHeight;

        return div;
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent HTML Injection
    |--------------------------------------------------------------------------
    */

    function escapeHtml(text) {

        const div = document.createElement('div');

        div.textContent = text;

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | Real-time Messages
    |--------------------------------------------------------------------------
    */

    // Track already-rendered message ids so real-time (Echo) and the polling
    // fallback never duplicate a message. Seed with the messages rendered
    // server-side on first load.
    const seenMessageIds = new Set(
        @json($session->chatMessages->isEmpty() ? [] : $session->chatMessages->modelKeys())
    );

    let lastSeenId = seenMessageIds.size ? Math.max(...seenMessageIds) : 0;


    Echo.private(`donation-session.${sessionId}`)
        .listen('.message.sent', (payload) => {

            if (payload.sender_id !== meId && !seenMessageIds.has(payload.id)) {

                seenMessageIds.add(payload.id);

                if (payload.id) {
                    lastSeenId = Math.max(lastSeenId, payload.id);
                }

                appendMessage(payload);

            }

        });


    /*
    |--------------------------------------------------------------------------
    | Send Message
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('chatForm');

    if (form) {

        form.addEventListener('submit', async (e) => {

            e.preventDefault();

            const input = document.getElementById('messageInput');

            const text = input.value.trim();

            if (!text) {
                return;
            }


            // Display immediately (optimistic).
            const optimisticNode = appendMessage({
                sender_id: meId,
                message: text,
                created_at_human: 'Sending…'
            });

            input.value = '';

            input.focus();


            try {

                const res = await fetch(`/chat/${sessionId}/send`, {

                    method: 'POST',

                    headers: {

                        'Content-Type': 'application/json',

                        'X-CSRF-TOKEN': window.csrfToken,

                        'Accept': 'application/json',

                        'X-Socket-ID': Echo.socketId(),

                    },

                    body: JSON.stringify({
                        message: text
                    }),

                });

                const timeEl = optimisticNode.querySelector('.message-time');

                if (!res.ok) {

                    throw new Error('Server responded with ' + res.status);

                }

                const { message } = await res.json();

                // Swap the "Sending…" stamp for the real server time.
                if (timeEl) {
                    timeEl.textContent = formatTime(message.created_at);
                }

            } catch (error) {

                console.error('Message sending failed:', error);

                const timeEl = optimisticNode.querySelector('.message-time');
                if (timeEl) {
                    timeEl.textContent = 'Failed to send. Tap to retry.';
                    timeEl.classList.add('text-danger');
                    timeEl.style.cursor = 'pointer';
                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Format a server timestamp like the server's "h:mm A" rendering
    |--------------------------------------------------------------------------
    */

    function formatTime(iso) {
        if (!iso) return '';
        const d = new Date(iso);
        if (isNaN(d)) return '';
        let h = d.getHours();
        const m = String(d.getMinutes()).padStart(2, '0');
        const hh = h % 12 === 0 ? 12 : h % 12;
        const ampm = h < 12 ? 'AM' : 'PM';
        return `${hh}:${m} ${ampm}`;
    }


    /*
    |--------------------------------------------------------------------------
    | Polling fallback (near-real-time receive)
    |
    | If Reverb / Echo isn't available, this keeps the chat alive by polling
    | the existing fetch endpoint. New messages are deduped against the
    | Echo listener via seenMessageIds, so nothing appears twice.
    |--------------------------------------------------------------------------
    */

    async function pollMessages() {
        try {
            const res = await fetch(`/chat/${sessionId}/fetch?after=${lastSeenId}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;

            const { messages } = await res.json();
            if (!messages || !messages.length) return;

            (messages ?? []).forEach((m) => {
                // Skip our own messages (rendered optimistically on send) and
                // anything Echo already appended.
                if (m.sender_id === meId) return;
                if (seenMessageIds.has(m.id)) return;

                seenMessageIds.add(m.id);
                if (typeof m.id === 'number') {
                    lastSeenId = Math.max(lastSeenId, m.id);
                }

                appendMessage(m);
            });
        } catch (e) {
            console.error('Message polling failed:', e);
        }
    }

    // Initial + recurring poll (every 5 seconds).
    pollMessages();
    setInterval(pollMessages, 5000);


    /*
    |--------------------------------------------------------------------------
    | Session Timer
    |--------------------------------------------------------------------------
    */

    const timerEl = document.getElementById('sessionTimer');

    if (timerEl) {

        const expiresAt =
            new Date(timerEl.dataset.expires).getTime();


        function updateTimer() {

            const diff = Math.max(
                0,
                expiresAt - Date.now()
            );


            const mins = String(
                Math.floor(diff / 60000)
            ).padStart(2, '0');


            const secs = String(
                Math.floor(
                    (diff % 60000) / 1000
                )
            ).padStart(2, '0');


            timerEl.textContent =
                `${mins}:${secs}`;


            if (diff <= 0) {

                timerEl.textContent = '00:00';

            }

        }


        updateTimer();

        setInterval(updateTimer, 1000);

    }

</script>

@endpush

@endsection