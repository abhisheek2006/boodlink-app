@extends('layouts.app')
@section('title', 'Blood Groups')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-droplet"></i> Blood Group Management</h4>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-lg"></i> Add Blood Group
    </button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-2 col-6">
        <div class="card p-3 text-center"><div class="text-muted small">Total</div><div class="fs-4 fw-bold">{{ $stats['total'] }}</div></div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card p-3 text-center"><div class="text-muted small">Active</div><div class="fs-4 fw-bold text-success">{{ $stats['active'] }}</div></div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card p-3 text-center"><div class="text-muted small">Inactive</div><div class="fs-4 fw-bold text-secondary">{{ $stats['inactive'] }}</div></div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card p-3 text-center"><div class="text-muted small">Most Requested</div><div class="fs-6 fw-bold">{{ $stats['most_requested']->name ?? '-' }}</div></div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card p-3 text-center"><div class="text-muted small">Highest Stock</div><div class="fs-6 fw-bold">{{ $stats['highest_stock']->name ?? '-' }}</div></div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card p-3 text-center"><div class="text-muted small">Lowest Stock</div><div class="fs-6 fw-bold">{{ $stats['lowest_stock']->name ?? '-' }}</div></div>
    </div>
</div>

<form class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name or description">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            <option value="Active" @selected(request('status') === 'Active')>Active</option>
            <option value="Inactive" @selected(request('status') === 'Inactive')>Inactive</option>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Blood Group</th><th>Description</th><th>Status</th>
                <th>Donors</th><th>Patients</th><th>Stock Units</th><th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bloodGroups as $bg)
                <tr>
                    <td class="fw-bold">{{ $bg->name }}</td>
                    <td>{{ $bg->description ?? '—' }}</td>
                    <td><span class="badge bg-{{ $bg->status === 'Active' ? 'success' : 'secondary' }}">{{ $bg->status }}</span></td>
                    <td>{{ $bg->donors_count }}</td>
                    <td>{{ $bg->patients_count }}</td>
                    <td>{{ $bg->bloodStock->units ?? 0 }}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $bg->id }}"><i class="bi bi-pencil"></i></button>

                        @if ($bg->status === 'Active')
                            <form action="{{ route('admin.blood-groups.deactivate', $bg) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pause"></i></button>
                            </form>
                        @else
                            <form action="{{ route('admin.blood-groups.activate', $bg) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-success"><i class="bi bi-play"></i></button>
                            </form>
                        @endif

                        <form action="{{ route('admin.blood-groups.destroy', $bg) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blood group?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $bg->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.blood-groups.update', $bg) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header"><h5 class="modal-title">Edit {{ $bg->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <label class="form-label">Name</label>
                                    <input name="name" value="{{ $bg->name }}" maxlength="10" class="form-control mb-2" required>
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control mb-2">{{ $bg->description }}</textarea>
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Active" @selected($bg->status === 'Active')>Active</option>
                                        <option value="Inactive" @selected($bg->status === 'Inactive')>Inactive</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No blood groups found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    </div>
</div>

<div class="mt-3">{{ $bloodGroups->links() }}</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.blood-groups.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Add Blood Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label">Name</label>
                    <input name="name" maxlength="10" class="form-control mb-2" required placeholder="e.g. A+">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control mb-2"></textarea>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Create</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
