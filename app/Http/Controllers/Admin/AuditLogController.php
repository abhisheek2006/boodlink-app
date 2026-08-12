<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = AuditLog::query()->with('admin');

        if ($action = $request->query('action')) {
            $query->where('action', $action);
        }

        if ($model = $request->query('model')) {
            $query->where('model_type', 'like', "%{$model}%");
        }

        if ($date = $request->query('date')) {
            $query->whereDate('created_at', $date);
        }

        $logs = $query->latest()->paginate(25)->withQueryString();

        $actions = AuditLog::select('action')
            ->distinct()
            ->pluck('action')
            ->sort()
            ->values();

        return view('admin.audit-logs', compact('logs', 'actions'));
    }
}
