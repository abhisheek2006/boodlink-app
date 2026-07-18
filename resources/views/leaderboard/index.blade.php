@extends('layouts.app')
@section('title', 'Leaderboard')

@section('content')
<h4 class="mb-4"><i class="bi bi-trophy text-warning"></i> Donor Leaderboard</h4>

<div class="card p-3">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Blood Group</th>
                <th>Total Donations</th>
                <th>Badge</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donors as $donor)
                <tr>
                    <td class="fw-bold">#{{ $donor->current_rank ?? $loop->iteration }}</td>
                    <td>
                        <i class="bi bi-person-circle text-secondary"></i>
                        {{ $donor->user->name }}
                    </td>
                    <td><span class="badge bg-danger">{{ $donor->bloodGroup->name ?? '-' }}</span></td>
                    <td>{{ $donor->total_donations }}</td>
                    <td>
                        @php
                            $badgeClass = match($donor->current_badge) {
                                'Platinum Donor' => 'badge-platinum',
                                'Gold Donor' => 'badge-gold',
                                'Silver Donor' => 'badge-silver',
                                'Bronze Donor' => 'badge-bronze',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $donor->current_badge ?? 'No Badge' }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No completed donations yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $donors->links() }}</div>
@endsection
