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

                @php
                    $sampleTemplates = [
                        [
                            'name' => 'Welcome to Blood Link',
                            'recipient_type' => 'All',
                            'subject' => 'Welcome to Blood Link — Thank you for joining',
                            'body' => "Dear Member,\n\nWelcome to Blood Link! We're thrilled to have you in our community of lifesavers.\n\nYour account is now active. You can update your profile, check your blood group, and start connecting with patients or donors near you.\n\nThank you for making a difference.\n\n— The Blood Link Team",
                        ],
                        [
                            'name' => 'Blood Donation Drive Invitation',
                            'recipient_type' => 'Donors',
                            'subject' => 'Join our upcoming Blood Donation Drive',
                            'body' => "Dear Donor,\n\nWe are organizing a blood donation drive and would love your support.\n\nDate: [DATE]\nTime: [TIME]\nVenue: [VENUE]\n\nEvery donation can save up to three lives. Please confirm your participation.\n\n— The Blood Link Team",
                        ],
                        [
                            'name' => 'Urgent Blood Requirement',
                            'recipient_type' => 'All',
                            'subject' => 'Urgent: Blood required — Please help',
                            'body' => "Dear Community,\n\nA patient urgently requires blood. If you or someone you know can help, please respond as soon as possible.\n\nBlood Group: [BLOOD GROUP]\nHospital: [HOSPITAL]\nContact: [CONTACT]\n\nThank you for your support.\n\n— The Blood Link Team",
                        ],
                        [
                            'name' => 'Thank You for Your Donation',
                            'recipient_type' => 'Donors',
                            'subject' => 'Thank you for your generous donation',
                            'body' => "Dear Donor,\n\nYour recent blood donation made a real difference. Thanks to you, a patient received the life-saving support they needed.\n\nWe look forward to seeing you at future drives.\n\n— The Blood Link Team",
                        ],
                        [
                            'name' => 'Membership / Account Notice',
                            'recipient_type' => 'All',
                            'subject' => 'Update on your Blood Link account',
                            'body' => "Dear Member,\n\nThis is an update regarding your Blood Link account.\n\n[ADD DETAILS]\n\nIf you have any questions, feel free to reach out.\n\n— The Blood Link Team",
                        ],
                    ];
                @endphp

                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-2"><i class="bi bi-magic me-1"></i> Sample Templates</div>
                        <p class="text-muted small mb-3">Click a sample to load its subject and message into the form.</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($sampleTemplates as $sample)
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm sample-btn"
                                    data-scope="{{ $sample['recipient_type'] }}"
                                    data-subject="{{ $sample['subject'] }}"
                                    data-body="{{ $sample['body'] }}"
                                >
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $sample['name'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.mail.send') }}" id="composeForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Recipient Scope</label>
                        <select name="recipient_type" id="recipientScope" class="form-select @error('recipient_type') is-invalid @enderror" required>
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
                        <input type="text" name="subject" id="subjectInput" class="form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject', $template->subject ?? '') }}" placeholder="Enter subject" required>
                        @error('subject')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea name="body" id="bodyInput" rows="8" class="form-control @error('body') is-invalid @enderror"
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

    document.querySelectorAll('.sample-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('recipientScope').value = this.dataset.scope;
            document.getElementById('subjectInput').value = this.dataset.subject;
            document.getElementById('bodyInput').value = this.dataset.body;
        });
    });
</script>
@endpush