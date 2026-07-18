@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<h4 class="mb-4"><i class="bi bi-file-earmark-bar-graph"></i> Reports</h4>

<div class="row g-3">
    @foreach ($reports as $key => $label)
        <div class="col-md-4">
            <div class="card p-3 h-100 d-flex flex-column">
                <h6 class="mb-3">{{ $label }}</h6>
                <div class="mt-auto d-flex gap-2">
                    <a href="{{ route('admin.reports.preview', $key) }}" class="btn btn-sm btn-outline-secondary flex-fill">Preview</a>
                    <a href="{{ route('admin.reports.pdf', $key) }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-filetype-pdf"></i></a>
                    <a href="{{ route('admin.reports.excel', $key) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-filetype-xlsx"></i></a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
