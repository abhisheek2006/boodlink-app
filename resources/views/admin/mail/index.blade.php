@extends('layouts.app')
@section('title', 'Mail Templates')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-envelope-paper me-2 text-secondary"></i> Mail Composer</h4>
    <a href="{{ route('admin.mail.create') }}" class="btn btn-primary btn-sm">Compose New</a>
</div>

<p class="text-muted small mb-3">Saved email templates for re-use. Click "Compose New" to write a fresh message to your users.</p>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th><th>Subject</th><th>Scope</th><th>Created By</th><th>Created</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr>
                            <td class="fw-semibold">{{ $template->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($template->subject, 45) }}</td>
                            <td><span class="badge bg-secondary">{{ $template->recipient_type }}</span></td>
                            <td>{{ $template->creator->name ?? '—' }}</td>
                            <td>{{ $template->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.mail.create', ['template' => $template->id]) }}" class="btn btn-sm btn-outline-secondary" title="Compose from this template"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('admin.mail.show', $template) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                                <form action="{{ route('admin.mail.templates.destroy', $template) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this template?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No saved templates yet. Create one from the compose screen.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $templates->links() }}</div>
@endsection
