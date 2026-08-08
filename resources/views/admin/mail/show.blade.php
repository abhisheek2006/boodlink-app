@extends('layouts.app')
@section('title', 'Template: {{ $template->name }}')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-eye me-2 text-secondary"></i> Template: {{ $template->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.mail.create', ['template' => $template->id]) }}" class="btn btn-primary btn-sm">Compose from Template</a>
        <a href="{{ route('admin.mail.index') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Subject</dt>
            <dd class="col-sm-9">{{ $template->subject }}</dd>

            <dt class="col-sm-3">Recipient Scope</dt>
            <dd class="col-sm-9"><span class="badge bg-secondary">{{ $template->recipient_type }}</span></dd>

            <dt class="col-sm-3">Created By</dt>
            <dd class="col-sm-9">{{ $template->creator->name ?? 'Unknown' }}</dd>

            <dt class="col-sm-3">Created At</dt>
            <dd class="col-sm-9">{{ $template->created_at->toFormattedDateString() }}</dd>

            <dt class="col-sm-3">Body</dt>
            <dd class="col-sm-9">
                <div class="border rounded bg-light p-3" style="max-height:320px; overflow:auto;">
                    {!! $template->body !!}
                </div>
            </dd>
        </dl>
    </div>
</div>
@endsection
