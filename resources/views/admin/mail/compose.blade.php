@extends('layouts.app')
@section('title', 'Compose Mail')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mt-3 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="bi bi-envelope-paper me-2 text-secondary"></i> Compose Mail</h4>
                    <a href="{{ route('admin.mail.index') }}" class="btn btn-outline-secondary btn-sm">Back to Templates</a>
                </div>

                <form method="POST" action="{{ route('admin.mail.send') }}" id="composeForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Recipient Scope</label>
                        <select name="recipient_type" class="form-select @error('recipient_type') is-invalid @enderror" required>
                            <option value="All" {{ old('recipient_type', $template->recipient_type ?? 'All') == 'All' ? 'selected' : '' }}>
                                All Users ({{ $scopeCounts['All'] ?? 0 }})
                            </option>
                            <option value="Donors" {{ old('recipient_type', $template->recipient_type ?? '') == 'Donors' ? 'selected' : '' }}>
                                Donors ({{ $scopeCounts['Donors'] ?? 0 }})
                            </option>
                            <option value="Patients" {{ old('recipient_type', $template->recipient_type ?? '') == 'Patients' ? 'selected' : '' }}>
                                Patients ({{ $scopeCounts['Patients'] ?? 0 }})
                            </option>
                            <option value="Admins" {{ old('recipient_type', $template->recipient_type ?? '') == 'Admins' ? 'selected' : '' }}>
                                Admins ({{ $scopeCounts['Admins'] ?? 0 }})
                            </option>
                        </select>
                        @error('recipient_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subject</label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject', $template->subject ?? '') }}" placeholder="Enter subject" required>
                        @error('subject')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea name="body" rows="8" class="form-control @error('body') is-invalid @enderror"
                                  placeholder="Write your message here..." required>{{ old('body', $template->body ?? '') }}</textarea>
                        @error('body')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="save_template" value="1" class="form-check-input" id="saveTemplate">
                        <label class="form-check-label" for="saveTemplate">
                            Save as a reusable template
                        </label>
                    </div>

                    <div id="templateNameField" class="mb-3 d-none">
                        <label class="form-label fw-semibold">Template Name</label>
                        <input type="text" name="template_name" class="form-control"
                               value="{{ old('template_name') }}" placeholder="e.g. Monthly Newsletter">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.mail.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('saveTemplate').addEventListener('change', function() {
        document.getElementById('templateNameField').classList.toggle('d-none', !this.checked);
    });
</script>
@endpush