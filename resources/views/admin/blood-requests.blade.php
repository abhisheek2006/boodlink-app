@extends('layouts.app')
@section('title', 'Blood Requests')

@section('content')
<h4 class="mb-4"><i class="bi bi-card-list me-2 text-secondary"></i> Blood Requests</h4>

<form class="row g-2 mb-3 align-items-end">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach (['Pending', 'Accepted', 'Completed', 'Cancelled', 'Rejected'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="emergency_level" class="form-select">
            <option value="">All Levels</option>
            @foreach (['Low', 'Medium', 'High', 'Critical'] as $s)
                <option value="{{ $s }}" @selected(request('emergency_level') === $s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Patient</th><th>Donor</th><th>Blood Group</th><th>Units</th><th>Emergency</th><th>Status</th><th>Created</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $r)
                        <tr>
                            <td>{{ $r->patient->user->name ?? '—' }}</td>
                            <td>{{ $r->donor->user->name ?? '—' }}</td>
                            <td>{{ $r->bloodGroup->name ?? '—' }}</td>
                            <td>{{ $r->units_required }}</td>
                            <td>
                                <span class="badge {{ match($r->emergency_level) { 'Critical' => 'bg-danger', 'High' => 'bg-warning text-dark', 'Medium' => 'bg-info', default => 'bg-secondary' } }}">
                                    {{ $r->emergency_level }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ match($r->status) { 'Pending' => 'bg-secondary', 'Accepted' => 'bg-info', 'Completed' => 'bg-success', 'Cancelled' => 'bg-secondary', 'Rejected' => 'bg-danger', default => 'bg-secondary' } }}">
                                    {{ $r->status }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $r->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.blood-requests.show', $r) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No blood requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $requests->links() }}</div>
@endsection
