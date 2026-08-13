<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodStock;
use App\Models\Donor;
use App\Models\DonationSession;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private const REPORTS = [
        'donors' => 'Total Donors',
        'patients' => 'Total Patients',
        'blood-requests' => 'Total Blood Requests',
        'blood-stock' => 'Available Blood Stock',
        'donation-sessions' => 'Donation Sessions',
        'completed-donations' => 'Completed Donations',
        'monthly-donations' => 'Monthly Donation Report',
        'blood-group-distribution' => 'Blood Group Distribution',
        'top-donors' => 'Top Donors',
    ];

    public function index(): View
    {
        return view('admin.reports.index', ['reports' => self::REPORTS]);
    }

    public function preview(string $report): View
    {
        return view('admin.reports.preview', [
            'title' => self::REPORTS[$report] ?? 'Report',
            'report' => $report,
            'rows' => $this->dataFor($report),
        ]);
    }

    public function exportPdf(string $report)
    {
        $pdf = Pdf::loadView('admin.reports.pdf', [
            'title' => self::REPORTS[$report] ?? 'Report',
            'rows' => $this->dataFor($report),
        ]);

        return $pdf->download("{$report}-report.pdf");
    }

    public function exportExcel(string $report)
    {
        $rows = $this->dataFor($report);

        return Excel::download(new \App\Exports\GenericCollectionExport($rows), "{$report}-report.xlsx");
    }

    private function dataFor(string $report): \Illuminate\Support\Collection
    {
        return match ($report) {
             'donors' => Donor::with(['user', 'bloodGroup'])->get()->map(fn ($d) => [
                'Name' => $d->user?->name ?? '—',
                'Blood Group' => $d->bloodGroup?->name ?? '—',
                'City' => $d->city ?? '—',
                'Total Donations' => $d->total_donations ?? 0,
                'Availability' => $d->availability ?? '—',
            ]),
            'patients' => Patient::with('user')->get()->map(fn ($p) => [
                'Name' => $p->user?->name ?? '—',
                'City' => $p->city ?? '—',
                'Emergency Contact' => $p->emergency_contact ?? '—',
            ]),
            'blood-requests' => DB::table('blood_requests')
                ->join('blood_groups', 'blood_requests.blood_group_id', '=', 'blood_groups.id')
                ->select('blood_requests.id', 'blood_groups.name as blood_group', 'blood_requests.units_required', 'blood_requests.emergency_level', 'blood_requests.status')
                ->get()->map(fn ($r) => (array) $r),
            'blood-stock' => BloodStock::with('bloodGroup')->get()->map(fn ($s) => [
                'Blood Group' => $s->bloodGroup?->name ?? '—',
                'Units' => $s->units ?? 0,
                'Status' => $s->status ?? '—',
            ]),
            'donation-sessions', 'completed-donations' => DonationSession::with(['donor.user', 'patient.user'])
                ->when($report === 'completed-donations', fn ($q) => $q->where('status', 'Completed'))
                ->get()->map(fn ($s) => [
                    'Donor' => $s->donor?->user?->name ?? '—',
                    'Patient' => $s->patient?->user?->name ?? '—',
                    'Status' => $s->status ?? '—',
                    'Started' => $s->started_at?->toDateTimeString() ?? '—',
                    'Ended' => $s->ended_at?->toDateTimeString() ?? '—',
                ]),
            'monthly-donations' => DB::table('donation_sessions')
                ->selectRaw("DATE_FORMAT(ended_at, '%Y-%m') as month, COUNT(*) as total")
                ->where('status', 'Completed')
                ->groupBy('month')->orderBy('month')->get()->map(fn ($r) => (array) $r),
            'blood-group-distribution' => DB::table('donors')
                ->join('blood_groups', 'donors.blood_group_id', '=', 'blood_groups.id')
                ->selectRaw('blood_groups.name as blood_group, COUNT(*) as total_donors')
                ->groupBy('blood_groups.name')->get()->map(fn ($r) => (array) $r),
            'top-donors' => Donor::with(['user', 'bloodGroup'])
                ->orderByDesc('total_donations')->limit(20)->get()->map(fn ($d) => [
                    'Name' => $d->user?->name ?? '—',
                    'Blood Group' => $d->bloodGroup?->name ?? '—',
                    'Total Donations' => $d->total_donations ?? 0,
                    'Badge' => $d->current_badge ?? '—',
                ]),
            default => collect(),
        };
    }
}
