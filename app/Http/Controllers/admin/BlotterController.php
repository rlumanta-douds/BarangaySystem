<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blotter;

class BlotterController extends Controller
{
    public function index()
    {
        $blotters = Blotter::latest()->get();
        return view('admin.blotter', compact('blotters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'complainant' => 'required|string|max:255',
            'respondent'  => 'required|string|max:255',
            'incident'    => 'required|string|max:255',
            'details'     => 'required|string',
            'status'      => 'required|string|max:50',
        ]);

        Blotter::create($validated);

        return redirect()->route('blotter.page')->with('success', 'Blotter record created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'complainant' => 'required|string|max:255',
            'respondent'  => 'required|string|max:255',
            'incident'    => 'required|string|max:255',
            'details'     => 'required|string',
            'status'      => 'required|string|max:50',
        ]);

        $blotter = Blotter::findOrFail($id);
        $blotter->update($validated);

        return redirect()->route('blotter.page')->with('success', 'Blotter record updated successfully!');
    }

    public function destroy($id)
    {
        $blotter = Blotter::findOrFail($id);
        $blotter->delete();

        return redirect()->route('blotter.page')->with('success', 'Blotter record deleted successfully!');
    }
}