@extends('layouts.app')
@section('title', $title)

@section('content')
<a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back</a>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">{{ $title }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reports.pdf', $report) }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-filetype-pdf"></i> PDF</a>
        <a href="{{ route('admin.reports.excel', $report) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-filetype-xlsx"></i> Excel</a>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Print</button>
    </div>
</div>

<div class="card p-3">
    @if ($rows->isEmpty())
        <p class="text-muted text-center py-4 mb-0">No data available for this report.</p>
    @else
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    @foreach (array_keys((array) $rows->first()) as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        @foreach ((array) $row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
