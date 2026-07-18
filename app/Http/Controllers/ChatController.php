<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use App\Models\DonationSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    /** Donor or patient: open their private chat screen for a session. */
    public function show(DonationSession $session, Request $request): View
    {
        $this->authorizeParticipant($session, $request);

        $session->load(['donor.user', 'patient.user', 'chatMessages' => fn ($q) => $q->orderBy('created_at')]);

        return view('chat.show', compact('session'));
    }

    /** Send a message (AJAX or standard form post). */
    public function send(DonationSession $session, Request $request): RedirectResponse|JsonResponse
    {
        $this->authorizeParticipant($session, $request);

        abort_unless($session->status === 'Active', 422, 'This chat is closed.');

        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'message_type' => ['sometimes', 'in:text,image,pdf'],
        ]);

        $senderId = $request->user()->id;
        $receiverId = $senderId === $session->donor->user_id
            ? $session->patient->user_id
            : $session->donor->user_id;

        $message = ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $data['message'],
            'message_type' => $data['message_type'] ?? 'text',
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return back();
    }

    /** Poll for new messages (used by the chat screen's AJAX refresh). */
    public function fetch(DonationSession $session, Request $request): JsonResponse
    {
        $this->authorizeParticipant($session, $request);

        $messages = $session->chatMessages()
            ->when($request->query('after'), fn ($q, $after) => $q->where('id', '>', $after))
            ->orderBy('created_at')
            ->get();

        $messages->where('receiver_id', $request->user()->id)->each->update(['seen' => true]);

        return response()->json(['messages' => $messages]);
    }

    // ── Admin read-only monitoring ───────────────────────────────

    public function adminIndex(Request $request): View
    {
        $query = DonationSession::with(['donor.user', 'patient.user']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('donor.user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('patient.user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $sessions = $query->latest('started_at')->paginate(20)->withQueryString();

        return view('admin.chats.index', compact('sessions'));
    }

    public function adminShow(DonationSession $session): View
    {
        $session->load(['donor.user', 'patient.user', 'chatMessages' => fn ($q) => $q->orderBy('created_at')]);

        return view('admin.chats.show', compact('session'));
    }

    private function authorizeParticipant(DonationSession $session, Request $request): void
    {
        $userId = $request->user()->id;

        abort_unless(
            $session->donor->user_id === $userId || $session->patient->user_id === $userId,
            403,
            'You are not a participant in this conversation.'
        );
    }
}
