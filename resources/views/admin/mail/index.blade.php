@extends('layouts.app')
@section('title', 'Mail Templates')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-envelope-paper me-2 text-secondary"></i> Mail Templates</h4>
    <a href="{{ route('admin.mail.create') }}" class="btn btn-primary btn-sm">New Template</a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if ($templates->isEmpty())
            <p class="text-muted text-center py-4">No saved templates yet. Create one to get started.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Scope</th>
                            <th>Created By</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td><span class="badge bg-secondary">{{ $template->recipient_type }}</span></td>
                                <td>{{ $template->creator->name ?? 'N/A' }}</td>
                                <td>{{ $template->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.mail.create', ['template' => $template->id]) }}" class="btn btn-sm btn-outline-secondary" title="Compose from this template">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.mail.show', $template) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.mail.templates.destroy', $template) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this template?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $templates->links() }}
        @endif
    </div>
</div>
@endsection