<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BloodGroupController extends Controller
{
    public function index(Request $request): View
    {
        $query = BloodGroup::withCount(['donors', 'patients', 'bloodRequests'])
            ->with('bloodStock');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $bloodGroups = $query->orderBy('name')->paginate(15)->withQueryString();

        $stats = [
            'total' => BloodGroup::count(),
            'active' => BloodGroup::where('status', 'Active')->count(),
            'inactive' => BloodGroup::where('status', 'Inactive')->count(),
            'most_requested' => BloodGroup::withCount('bloodRequests')
                ->orderByDesc('blood_requests_count')->first(),
            'highest_stock' => BloodGroup::with('bloodStock')
                ->get()->sortByDesc(fn ($bg) => $bg->bloodStock->units ?? 0)->first(),
            'lowest_stock' => BloodGroup::with('bloodStock')
                ->get()->sortBy(fn ($bg) => $bg->bloodStock->units ?? 0)->first(),
        ];

        return view('admin.blood-groups.index', compact('bloodGroups', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:10', 'unique:blood_groups,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        BloodGroup::create($data);

        return back()->with('success', 'Blood group created successfully.');
    }

    public function update(Request $request, BloodGroup $bloodGroup): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:10', Rule::unique('blood_groups', 'name')->ignore($bloodGroup->id)],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $bloodGroup->update($data);

        return back()->with('success', 'Blood group updated successfully.');
    }

    public function activate(BloodGroup $bloodGroup): RedirectResponse
    {
        $bloodGroup->update(['status' => 'Active']);

        return back()->with('success', "{$bloodGroup->name} is now active.");
    }

    public function deactivate(BloodGroup $bloodGroup): RedirectResponse
    {
        $bloodGroup->update(['status' => 'Inactive']);

        return back()->with('success', "{$bloodGroup->name} is now inactive.");
    }

    public function destroy(BloodGroup $bloodGroup): RedirectResponse
    {
        if ($bloodGroup->isInUse()) {
            return back()->withErrors([
                'blood_group' => 'This blood group cannot be deleted because it is currently in use.',
            ]);
        }

        $bloodGroup->delete();

        return back()->with('success', 'Blood group deleted successfully.');
    }
}
