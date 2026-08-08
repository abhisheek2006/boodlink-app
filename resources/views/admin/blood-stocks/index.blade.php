@extends('layouts.app')
@section('title', 'Blood Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-boxes"></i> Blood Inventory</h4>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStockModal">
        <i class="bi bi-plus-lg"></i> Add Stock Entry
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr><th>Blood Group</th><th>Units Available</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($stocks as $stock)
                <tr>
                    <td class="fw-bold">{{ $stock->bloodGroup->name }}</td>
                    <td>{{ $stock->units }}</td>
                    <td>
                        <span class="badge bg-{{ match($stock->status) { 'Sufficient' => 'success', 'Low' => 'warning', 'Critical' => 'danger', default => 'secondary' } }}">
                            {{ $stock->status }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('admin.blood-stocks.update', $stock) }}" method="POST" class="d-inline-flex gap-1">
                            @csrf @method('PUT')
                            <input type="number" name="units" value="{{ $stock->units }}" min="0" class="form-control form-control-sm" style="width: 90px;">
                            <button class="btn btn-sm btn-outline-primary">Update</button>
                        </form>
                        <form action="{{ route('admin.blood-stocks.destroy', $stock) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this stock entry?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No stock entries yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    </div>
</div>

<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.blood-stocks.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Add Stock Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label">Blood Group</label>
                    <select name="blood_group_id" class="form-select mb-2" required>
                        @foreach (\App\Models\BloodGroup::where('status', 'Active')->orderBy('name')->get() as $bg)
                            <option value="{{ $bg->id }}">{{ $bg->name }}</option>
                        @endforeach
                    </select>
                    <label class="form-label">Units</label>
                    <input type="number" name="units" min="0" class="form-control" required>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Add</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
