@extends('layouts.app')
@section('title', 'Compose Mail')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-envelope-paper me-2 text-secondary"></i> Compose Mail</h4>
    <a href="{{ route('admin.mail.index') }}" class="btn btn-outline-secondary btn-sm">Back to Templates</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent">
        <h6 class="mb-0">New Message</h6>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.mail.send') }}" id="composeForm">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Recipient Scope</label>
                    <select name="recipient_type" class="form-select" required>
                        <option value="All">Everyone (all users)</option>
                        <option value="Donors">Donors only</option>
                        <option value="Patients">Patients only</option>
                        <option value="Admins">Administrators only</option>
                    </select>
                    <div class="form-text small">The email will be sent to every user matching this scope.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" value="{{ $template?->subject ?? '' }}" class="form-control" placeholder="Email subject" required maxlength="255">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Message Body (HTML supported)</label>
                <div class="mb-2 d-flex flex-wrap gap-1">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('bold')">Bold</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('italic')">Italic</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertBr()">Line Break</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('strong')">Strong</button>
                </div>
                <textarea name="body" id="mailBody" class="form-control font-mono" rows="14" placeholder="<p>Hello,</p><p>...</p>" required>{{ $template?->body ?? '' }}</textarea>
                <div class="form-text small">You may use HTML tags. A live preview of styling is shown in the email.</div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="save_template" id="saveTemplate" class="form-check-input" value="1">
                <label class="form-check-label" for="saveTemplate">Save as reusable template</label>
            </div>

            <div id="templateNameField" class="mb-3" style="display:none;">
                <label class="form-label">Template Name</label>
                <input type="text" name="template_name" class="form-control" placeholder="e.g. Monthly Newsletter">
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button type="submit" class="btn btn-danger px-4">Send Now</button>
                    &nbsp;<a href="{{ route('admin.mail.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
                <div class="text-end">
                    <span class="text-muted small">Recipients matched: <span id="recipientCount">…</span></span>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ── Basic HTML helper buttons ──────────────────────────────
    function insertTag(tag) {
        const area = document.getElementById('mailBody');
        const start = area.selectionStart;
        const end   = area.selectionEnd;
        const selected = area.value.substring(start, end);
        let html;
        if (tag === 'bold' || tag === 'strong') {
            html = `<${tag}>${selected || 'highlighted text'}</${tag}>`;
        } else if (tag === 'italic') {
            html = `<em>${selected || 'emphasized text'}</em>`;
        }
        area.value = area.value.substring(0, start) + html + area.value.substring(end);
        area.focus();
    }
    function insertBr() {
        const area = document.getElementById('mailBody');
        const start = area.selectionStart;
        const end   = area.selectionEnd;
        area.value = area.value.substring(0, start) + '<br>' + area.value.substring(end);
        area.focus();
    }

    // ── Toggle template-name field ─────────────────────────────
    document.getElementById('saveTemplate').addEventListener('change', function () {
        document.getElementById('templateNameField').style.display = this.checked ? 'block' : 'none';
    });

    // ── Recipient counts ────────────────────────────────────────
    const scopeCounts = @json($scopeCounts ?? []);
    const select = document.querySelector('select[name="recipient_type"]');
    function updateCount() {
        document.getElementById('recipientCount').textContent = scopeCounts[select.value] ?? 0;
    }
    select.addEventListener('change', updateCount);
    updateCount();

    // ── Confirm before send ─────────────────────────────────────
    document.getElementById('composeForm').addEventListener('submit', function (e) {
        if (!confirm('Send this email to all matching recipients now?')) {
            e.preventDefault();
        }
    });
</script>
@endpush
@endsection
