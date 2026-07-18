<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BloodStockController extends Controller
{
    public function index(Request $request): View
    {
        $query = BloodStock::with('bloodGroup');

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $stocks = $query->get()->sortBy(fn ($stock) => $stock->bloodGroup->name);

        return view('admin.blood-stocks.index', compact('stocks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'blood_group_id' => ['required', 'exists:blood_groups,id', 'unique:blood_stocks,blood_group_id'],
            'units' => ['required', 'integer', 'min:0'],
        ]);

        $stock = new BloodStock($data);
        $stock->refreshStatus();
        $stock->save();

        return back()->with('success', 'Blood stock entry added.');
    }

    public function update(Request $request, BloodStock $bloodStock): RedirectResponse
    {
        $data = $request->validate([
            'units' => ['required', 'integer', 'min:0'],
        ]);

        $bloodStock->fill($data);
        $bloodStock->refreshStatus();
        $bloodStock->save();

        return back()->with('success', 'Blood stock updated.');
    }

    public function destroy(BloodStock $bloodStock): RedirectResponse
    {
        $bloodStock->delete();

        return back()->with('success', 'Blood stock entry removed.');
    }
}
