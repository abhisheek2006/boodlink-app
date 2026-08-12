@extends('layouts.app')
@section('title', 'Audit Log')

@section('content')
<h4 class="mb-4"><i class="bi bi-shield-check me-2 text-secondary"></i> Audit Log</h4>

<form class="row g-2 mb-3 align-items-end">
    <div class="col-md-3">
        <label class="form-label small">Action</label>
        <select name="action" class="form-select">
            <option value="">All Actions</option>
            @foreach ($actions as $a)
                <option value="{{ $a }}" @selected(request('action') === $a)>{{ ucfirst($a) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label small">Model</label>
        <input type="text" name="model" value="{{ request('model') }}" class="form-control" placeholder="e.g. BloodRequest">
    </div>
    <div class="col-md-2">
        <label class="form-label small">Date</label>
        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
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
                        <th>Time</th>
                        <th>Action</th>
                        <th>Admin</th>
                        <th>Model</th>
                        <th>ID</th>
                        <th>Metadata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('M d, H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                            <td>{{ $log->admin?->name ?? 'System' }}</td>
                            <td class="text-muted small">{{ class_basename($log->model_type) ?? '—' }}</td>
                            <td>{{ $log->model_id ?? '—' }}</td>
                            <td class="text-muted small">
                                @if ($log->metadata)
                                    @foreach ($log->metadata as $k => $v)
                                        <span class="badge bg-light text-dark">{{ $k }}: {{ $v }}</span>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No audit logs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $logs->links() }}</div>
@endsection
