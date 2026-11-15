<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::latest()->get();

        return view('admin.residents.index', compact('residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'status'  => 'required|string|max:50',
        ]);

        Resident::create([
            'resident_id' => '#RES-' . rand(1000, 9999),
            'name'        => $validated['name'],
            'address'     => $validated['address'],
            'contact'     => $validated['contact'],
            'status'      => $validated['status'],
        ]);

        return redirect()->route('residents.page')->with('success', 'Resident added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'status'  => 'required|string|max:50',
        ]);

        $resident = Resident::findOrFail($id);
        $resident->update([
            'name'    => $validated['name'],
            'address' => $validated['address'],
            'contact' => $validated['contact'],
            'status'  => $validated['status'],
        ]);

        return redirect()->route('residents.page')->with('success', 'Resident updated successfully!');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return redirect()->route('residents.page')->with('success', 'Resident deleted successfully!');
    }
}