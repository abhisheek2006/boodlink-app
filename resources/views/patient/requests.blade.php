@extends('layouts.app')
@section('title', 'My Requests')

@section('content')
<h4 class="mb-4">My Blood Requests</h4>

<div class="card border-0 shadow-sm">
    <table class="table align-middle">
        <thead>
            <tr><th>Date</th><th>Donor</th><th>Blood Group</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($requests as $request)
                <tr>
                    <td>{{ $request->created_at->toFormattedDateString() }}</td>
                    <td>{{ $request->donor?->user->name ?? '—' }}</td>
                    <td><span class="badge bg-danger">{{ $request->bloodGroup->name }}</span></td>
                    <td>
                        @php
                            $color = match($request->status) {
                                'Completed' => 'success', 'Accepted' => 'primary',
                                'Rejected', 'Cancelled' => 'secondary', default => 'warning',
                            };
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ $request->status }}</span>
                    </td>
                    <td>
                        @if ($request->status === 'Pending')
                            <form method="POST" action="{{ route('patient.requests.cancel', $request) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-danger">Cancel</button>
                            </form>
                        @elseif ($request->status === 'Accepted' && $request->donationSession)
                            <a href="{{ route('chat.show', $request->donationSession) }}" class="btn btn-sm btn-primary">Open Chat</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No requests yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $requests->links() }}
</div>
@endsection
