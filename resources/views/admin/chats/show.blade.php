@extends('layouts.app')

@section('title', 'Conversation')

@section('content')

<style>
    /* ================================
       Conversation Page
       ================================ */

    .conversation-page {
        padding: 8px 0 30px;
    }

    /* Back Button */
    .conversation-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        margin-bottom: 28px;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        background: #fff;
        color: #172033;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.05);
        transition: all .2s ease;
    }

    .conversation-back:hover {
        color: #e51f2a;
        border-color: #ffd6d9;
        transform: translateY(-1px);
    }

    .conversation-back i {
        font-size: 17px;
    }

    /* ================================
       Information Cards
       ================================ */

    .conversation-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        margin-bottom: 30px;
    }

    .conversation-info-card {
        min-height: 150px;
        padding: 24px;
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.055);
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .conversation-info-icon {
        width: 62px;
        height: 62px;
        min-width: 62px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .donor-icon {
        color: #e51f2a;
        background: #fff0f1;
    }

    .patient-icon {
        color: #5146d8;
        background: #f0efff;
    }

    .session-icon {
        color: #16a765;
        background: #eefbf4;
    }

    .conversation-info-content {
        min-width: 0;
    }

    .conversation-info-label {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .conversation-info-name {
        color: #111827;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .conversation-info-subtitle {
        color: #64748b;
        font-size: 14px;
    }

    .blood-group {
        color: #e51f2a;
        font-weight: 600;
    }

    /* Session status */
    .session-card {
        align-items: flex-start;
    }

    .session-details {
        margin-top: 8px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.65;
    }

    .session-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border-radius: 9px;
        background: #fff0f1;
        color: #dc2630;
        font-size: 13px;
        font-weight: 700;
    }

    .session-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #dc2630;
    }

    /* ================================
       Read Only Alert
       ================================ */

    .readonly-alert {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px 25px;
        margin-bottom: 22px;
        background: #fffafa;
        border: 1px solid #ffccd0;
        border-radius: 15px;
        color: #172033;
        font-size: 16px;
    }

    .readonly-alert i {
        color: #e51f2a;
        font-size: 23px;
    }

    .readonly-alert strong {
        color: #df252f;
        font-weight: 700;
    }

    /* ================================
       Chat Container
       ================================ */

    .conversation-chat-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.055);
        overflow: hidden;
    }

    .conversation-chat-body {
        height: 500px;
        padding: 30px 24px;
        overflow-y: auto;
        background:
            radial-gradient(circle at top left, rgba(255, 238, 240, .22), transparent 35%),
            #fff;
        scroll-behavior: smooth;
    }

    .conversation-chat-body::-webkit-scrollbar {
        width: 7px;
    }

    .conversation-chat-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .conversation-chat-body::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 20px;
    }

    /* Message row */
    .chat-message-row {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 25px;
    }

    .chat-message-row.patient {
        justify-content: flex-end;
    }

    /* Avatar */
    .chat-avatar {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .donor-avatar {
        background: #fff0f1;
        color: #e51f2a;
    }

    .patient-avatar {
        background: #f0efff;
        color: #5146d8;
        order: 2;
    }

    /* Message bubble */
    .chat-bubble {
        position: relative;
        max-width: 62%;
        padding: 16px 20px;
        border-radius: 16px;
        background: #f5f6f8;
        color: #172033;
    }

    .chat-message-row.donor .chat-bubble {
        border-top-left-radius: 5px;
    }

    .chat-message-row.patient .chat-bubble {
        background: linear-gradient(135deg, #ffe4e6, #ffd9dc);
        border-top-right-radius: 5px;
    }

    .chat-sender {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #172033;
    }

    .chat-message {
        font-size: 15px;
        line-height: 1.55;
        word-break: break-word;
    }

    .chat-time {
        margin-top: 9px;
        color: #64748b;
        font-size: 12px;
    }

    /* Empty state */
    .chat-empty {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #94a3b8;
        text-align: center;
    }

    .chat-empty i {
        font-size: 45px;
        margin-bottom: 12px;
        color: #e51f2a;
        opacity: .65;
    }

    .chat-empty p {
        margin: 0;
        font-size: 14px;
    }

    /* ================================
       Responsive
       ================================ */

    @media (max-width: 992px) {
        .conversation-info-grid {
            grid-template-columns: 1fr;
        }

        .chat-bubble {
            max-width: 75%;
        }
    }

    @media (max-width: 768px) {
        .conversation-page {
            padding: 5px 0 20px;
        }

        .conversation-info-card {
            padding: 18px;
            min-height: 120px;
        }

        .conversation-info-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            font-size: 22px;
        }

        .conversation-info-name {
            font-size: 16px;
        }

        .readonly-alert {
            font-size: 14px;
            padding: 14px 16px;
        }

        .conversation-chat-body {
            height: 450px;
            padding: 20px 14px;
        }

        .chat-bubble {
            max-width: 82%;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
        }
    }
</style>


<div class="conversation-page">

    {{-- Back --}}
    <a href="{{ route('admin.chats.index') }}" class="conversation-back">
        <i class="bi bi-arrow-left"></i>
        <span>Back to Chat List</span>
    </a>


    {{-- =========================
         DONOR / PATIENT / SESSION
         ========================= --}}
    <div class="conversation-info-grid">

        {{-- Donor --}}
        <div class="conversation-info-card">

            <div class="conversation-info-icon donor-icon">
                <i class="bi bi-person-heart"></i>
            </div>

            <div class="conversation-info-content">

                <div class="conversation-info-label">
                    Donor
                </div>

                <div class="conversation-info-name">
                    {{ $session->donor->user->name }}
                </div>

                <div class="conversation-info-subtitle">
                    <span class="blood-group">
                        <i class="bi bi-droplet-fill me-1"></i>
                        {{ $session->donor->bloodGroup->name ?? '—' }}
                    </span>
                </div>

            </div>

        </div>


        {{-- Patient --}}
        <div class="conversation-info-card">

            <div class="conversation-info-icon patient-icon">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="conversation-info-content">

                <div class="conversation-info-label">
                    Patient
                </div>

                <div class="conversation-info-name">
                    {{ $session->patient->user->name }}
                </div>

            </div>

        </div>


        {{-- Session --}}
        <div class="conversation-info-card session-card">

            <div class="conversation-info-icon session-icon">
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="conversation-info-content">

                <div class="conversation-info-label">
                    Session Status
                </div>

                <div>
                    <span class="session-status">
                        <span class="session-status-dot"></span>
                        {{ $session->status }}
                    </span>
                </div>

                <div class="session-details">

                    <div>
                        Started
                        {{ optional($session->started_at)->format('d M Y, h:i A') ?? '—' }}
                    </div>

                    @if ($session->ended_at)
                        <div>
                            Ended
                            {{ $session->ended_at->format('d M Y, h:i A') }}
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         READ ONLY NOTICE
         ========================= --}}
    <div class="readonly-alert">

        <i class="bi bi-eye"></i>

        <div>
            <strong>Read-only</strong>
            <span> — administrators cannot send messages</span>
        </div>

    </div>


    {{-- =========================
         CHAT
         ========================= --}}
    <div class="conversation-chat-card">

        <div
            class="conversation-chat-body"
            id="adminChatBody"
        >

            @forelse ($session->chatMessages as $message)

                @php
                    $fromDonor = $message->sender_id === $session->donor->user_id;
                @endphp

                <div class="chat-message-row {{ $fromDonor ? 'donor' : 'patient' }}">

                    {{-- Avatar --}}
                    <div class="chat-avatar {{ $fromDonor ? 'donor-avatar' : 'patient-avatar' }}">
                        <i class="bi bi-person-fill"></i>
                    </div>


                    {{-- Bubble --}}
                    <div class="chat-bubble">

                        <div class="chat-sender">
                            {{ $fromDonor
                                ? $session->donor->user->name
                                : $session->patient->user->name
                            }}
                        </div>

                        <div class="chat-message">
                            {{ $message->message }}
                        </div>

                        <div class="chat-time">
                            {{ $message->created_at->format('d M Y, h:i A') }}
                        </div>

                    </div>

                </div>

            @empty

                <div class="chat-empty" id="adminChatEmpty">

                    <i class="bi bi-chat-heart"></i>

                    <p>
                        No messages exchanged yet.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>


@push('scripts')

<script>

    const donorUserId = {!! json_encode((int) $session->donor->user_id, JSON_THROW_ON_ERROR) !!};
    const donorName = {!! json_encode($session->donor->user->name ?? null, JSON_THROW_ON_ERROR) !!};
    const patientName = {!! json_encode($session->patient->user->name ?? null, JSON_THROW_ON_ERROR) !!};

    const adminChatBody = document.getElementById('adminChatBody');
    const adminChatBody =
        document.getElementById('adminChatBody');


    /*
    |--------------------------------------------------------------------------
    | Live Chat Monitoring
    |--------------------------------------------------------------------------
    | Admin can only watch messages.
    | Admin cannot send messages.
    |--------------------------------------------------------------------------
    */

    Echo.private(
        `donation-session.{{ $session->id }}`
    ).listen('.message.sent', (m) => {

        document
            .getElementById('adminChatEmpty')
            ?.remove();


        const fromDonor =
            Number(m.sender_id) === Number(donorUserId);


        /*
        |--------------------------------------------------------------------------
        | Message Row
        |--------------------------------------------------------------------------
        */

        const row =
            document.createElement('div');

        row.className =
            `chat-message-row ${fromDonor ? 'donor' : 'patient'}`;


        /*
        |--------------------------------------------------------------------------
        | Avatar
        |--------------------------------------------------------------------------
        */

        const avatar =
            document.createElement('div');

        avatar.className =
            `chat-avatar ${
                fromDonor
                    ? 'donor-avatar'
                    : 'patient-avatar'
            }`;

        avatar.innerHTML =
            '<i class="bi bi-person-fill"></i>';


        /*
        |--------------------------------------------------------------------------
        | Bubble
        |--------------------------------------------------------------------------
        */

        const bubble =
            document.createElement('div');

        bubble.className =
            'chat-bubble';


        /*
        |--------------------------------------------------------------------------
        | Sender
        |--------------------------------------------------------------------------
        */

        const sender =
            document.createElement('div');

        sender.className =
            'chat-sender';

        sender.textContent =
            fromDonor
                ? donorName
                : patientName;


        /*
        |--------------------------------------------------------------------------
        | Message
        |--------------------------------------------------------------------------
        */

        const message =
            document.createElement('div');

        message.className =
            'chat-message';

        message.textContent =
            m.message ?? '';


        /*
        |--------------------------------------------------------------------------
        | Time
        |--------------------------------------------------------------------------
        */

        const time =
            document.createElement('div');

        time.className =
            'chat-time';

        time.textContent =
            m.created_at_human ?? '';


        /*
        |--------------------------------------------------------------------------
        | Build Bubble
        |--------------------------------------------------------------------------
        */

        bubble.appendChild(sender);

        bubble.appendChild(message);

        bubble.appendChild(time);


        /*
        |--------------------------------------------------------------------------
        | Build Row
        |--------------------------------------------------------------------------
        */

        row.appendChild(avatar);

        row.appendChild(bubble);


        /*
        |--------------------------------------------------------------------------
        | Patient avatar should appear on right
        |--------------------------------------------------------------------------
        */

        if (!fromDonor) {

            row.appendChild(avatar);

            row.appendChild(bubble);

            row.innerHTML = '';

            row.appendChild(bubble);
            row.appendChild(avatar);

        }


        adminChatBody.appendChild(row);


        /*
        |--------------------------------------------------------------------------
        | Auto Scroll
        |--------------------------------------------------------------------------
        */

        adminChatBody.scrollTop =
            adminChatBody.scrollHeight;

    });

</script>

@endpush

@endsection