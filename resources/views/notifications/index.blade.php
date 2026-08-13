@extends('layouts.app')
@section('title', 'Notifications')

@section('content')

<style>
    .notifications-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        gap: 15px;
    }

    .notifications-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notifications-title-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #fff0f1;
        color: #ef233c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .notifications-title h4 {
        margin: 0;
        color: #14213d;
        font-weight: 700;
    }

    .notifications-subtitle {
        margin: 3px 0 0;
        color: #8a94a6;
        font-size: 12px;
    }

    .mark-all-btn {
        border-radius: 9px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 600;
    }

    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notification-item {
        position: relative;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding: 18px 20px;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(20, 33, 61, 0.04);
        transition: all .2s ease;
    }

    .notification-item:hover {
        border-color: #e1e5eb;
        box-shadow: 0 6px 18px rgba(20, 33, 61, 0.07);
        transform: translateY(-1px);
    }

    .notification-item.unread {
        background: #fffafa;
        border-left: 4px solid #ef233c;
    }

    .notification-main {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        min-width: 0;
        flex: 1;
    }

    .notification-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 12px;
        background: #f3f5f8;
        color: #687386;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .notification-item.unread .notification-icon {
        background: #fff0f1;
        color: #ef233c;
    }

    .notification-content {
        min-width: 0;
    }

    .notification-title {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 4px;
        color: #172033;
        font-size: 14px;
        font-weight: 700;
    }

    .new-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 7px;
        border-radius: 6px;
        background: #ef233c;
        color: #ffffff;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .notification-message {
        margin: 0 0 6px;
        color: #687386;
        font-size: 13px;
        line-height: 1.55;
    }

    .notification-time {
        color: #9aa3b2;
        font-size: 11px;
    }

    .notification-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .notification-action {
        width: 34px;
        height: 34px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .empty-notifications {
        padding: 65px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 15px;
        box-shadow: 0 4px 14px rgba(20, 33, 61, 0.04);
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 14px;
        border-radius: 50%;
        background: #f4f6f8;
        color: #9aa3b2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
    }

    .empty-title {
        color: #172033;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .empty-text {
        color: #9aa3b2;
        font-size: 12px;
        margin: 0;
    }

    .pagination-wrapper {
        margin-top: 18px;
    }

    @media (max-width: 600px) {

        .notifications-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .mark-all-btn {
            width: 100%;
        }

        .notification-item {
            padding: 15px;
            gap: 10px;
        }

        .notification-main {
            gap: 10px;
        }

        .notification-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
            font-size: 16px;
        }

        .notification-actions {
            flex-direction: column;
        }

        .notification-message {
            font-size: 12px;
        }
    }
</style>


<div class="notifications-page">

    {{-- Page Header --}}
    <div class="notifications-header">

        <div class="notifications-title">

            <div class="notifications-title-icon">
                <i class="bi bi-bell-fill"></i>
            </div>

            <div>
                <h4>Notifications</h4>

                <p class="notifications-subtitle">
                    Stay updated with your Blood Link activity
                </p>
            </div>

        </div>


        {{-- Mark All --}}
        <form
            action="{{ route('notifications.read-all') }}"
            method="POST"
        >
            @csrf
            @method('PATCH')

            <button
                type="submit"
                class="btn btn-outline-secondary mark-all-btn"
            >
                <i class="bi bi-check2-all me-1"></i>
                Mark all as read
            </button>

        </form>

    </div>


    {{-- Notifications --}}
    @if ($notifications->count())

        <div class="notification-list">

            @foreach ($notifications as $notification)

                <div
                    class="notification-item {{ $notification->is_read ? '' : 'unread' }}"
                >

                    <div class="notification-main">

                        {{-- Icon --}}
                        <div class="notification-icon">

                            @if (!$notification->is_read)
                                <i class="bi bi-bell-fill"></i>
                            @else
                                <i class="bi bi-bell"></i>
                            @endif

                        </div>


                        {{-- Content --}}
                        <div class="notification-content">

                            <div class="notification-title">

                                @unless ($notification->is_read)

                                    <span class="new-badge">
                                        New
                                    </span>

                                @endunless

                                {{ $notification->title }}

                            </div>


                            <p class="notification-message">
                                {{ $notification->message }}
                            </p>


                            <div class="notification-time">

                                <i class="bi bi-clock me-1"></i>

                                {{ $notification->created_at->diffForHumans() }}

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="notification-actions">

                        @unless ($notification->is_read)

                            <form
                                action="{{ route('notifications.read', $notification) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-secondary notification-action"
                                    title="Mark as read"
                                >
                                    <i class="bi bi-check2"></i>
                                </button>

                            </form>

                        @endunless


                        <form
                            action="{{ route('notifications.destroy', $notification) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this notification?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger notification-action"
                                title="Delete"
                            >
                                <i class="bi bi-trash3"></i>
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- Empty State --}}
        <div class="empty-notifications">

            <div class="empty-icon">
                <i class="bi bi-bell-slash"></i>
            </div>

            <div class="empty-title">
                No notifications yet
            </div>

            <p class="empty-text">
                You're all caught up. New notifications will appear here.
            </p>

        </div>

    @endif


    {{-- Pagination --}}
    @if ($notifications->hasPages())

        <div class="pagination-wrapper">
            {{ $notifications->links() }}
        </div>

    @endif

</div>

@endsection