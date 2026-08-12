@extends('layouts.app')
@section('title', 'View Template')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mt-3 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="bi bi-envelope-paper me-2 text-secondary"></i> Template: {{ $template->name }}</h4>
                    <a href="{{ route('admin.mail.index') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject</label>
                    <input type="text" class="form-control" value="{{ $template->subject }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Recipient Scope</label>
                    <input type="text" class="form-control" value="{{ $template->recipient_type }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Message</label>
                    <div class="border rounded p-3 bg-light" style="min-height: 200px;">
                        {!! nl2br(e($template->body)) !!}
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.mail.create', ['template' => $template->id]) }}" class="btn btn-primary">
                        Compose from This Template
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection