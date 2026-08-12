<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminNotificationMail;
use App\Models\MailTemplate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MailController extends Controller
{
    public function index(Request $request): View
    {
        $templates = MailTemplate::latest()->with('creator')->paginate(15)->withQueryString();

        return view('admin.mail.index', compact('templates'));
    }

    public function create(Request $request): View
    {
        $template = $request->query('template')
            ? MailTemplate::findOrFail($request->query('template'))
            : null;

        $scopeCounts = [
            'All'      => User::whereNotNull('email')->count(),
            'Donors'   => User::where('role', 'Donor')->whereNotNull('email')->count(),
            'Patients' => User::where('role', 'Patient')->whereNotNull('email')->count(),
            'Admins'   => User::where('role', 'Admin')->whereNotNull('email')->count(),
        ];

        return view('admin.mail.compose', compact('template', 'scopeCounts'));
    }

    public function storeTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:100'],
            'subject'        => ['required', 'string', 'max:255'],
            'body'           => ['required', 'string'],
            'recipient_type' => ['required', 'in:All,Donors,Patients,Admins'],
        ]);

        $data['created_by'] = $request->user()->id;

        MailTemplate::create($data);

        return redirect()->route('admin.mail.index')->with('success', 'Template saved.');
    }

    public function show(MailTemplate $template): View
    {
        return view('admin.mail.show', compact('template'));
    }

    public function destroyTemplate(MailTemplate $template): RedirectResponse
    {
        $template->delete();

        return back()->with('success', 'Template deleted.');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'subject'        => ['required', 'string', 'max:255'],
            'body'           => ['required', 'string'],
            'recipient_type' => ['required', 'in:All,Donors,Patients,Admins'],
        ]);

        if ($request->boolean('save_template')) {
            MailTemplate::create([
                'name'           => $request->input('template_name', 'Untitled'),
                'subject'        => $data['subject'],
                'body'           => $data['body'],
                'recipient_type' => $data['recipient_type'],
                'created_by'     => $request->user()->id,
            ]);
        }

        $users = $this->resolveRecipients($data['recipient_type']);

        if ($users->isEmpty()) {
            return back()->with('success', 'No recipients matched the selected scope.');
        }

        $sent = 0;
        foreach ($users as $user) {
            if (! $user->email) {
                continue;
            }
            try {
                Mail::to($user->email)->send(
                    new AdminNotificationMail($data['subject'], $data['body'])
                );
                $sent++;
            } catch (\Throwable $e) {
            }
        }

        return redirect()->route('admin.mail.index')
            ->with('success', "Email sent to {$sent} recipient(s).");
    }

    protected function resolveRecipients(string $scope)
    {
        return match ($scope) {
            'Donors'  => User::where('role', 'Donor')->whereNotNull('email')->get(),
            'Patients' => User::where('role', 'Patient')->whereNotNull('email')->get(),
            'Admins'  => User::where('role', 'Admin')->whereNotNull('email')->get(),
            default   => User::whereNotNull('email')->get(),
        };
    }
}
