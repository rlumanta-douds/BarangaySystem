<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display announcements management page.
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'category'  => 'required|string|max:100',
            'posted_by' => 'nullable|string|max:100',
        ]);

        Announcement::create([
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'category'  => $validated['category'],
            'posted_by' => $validated['posted_by'] ?? 'Admin',
        ]);

        return redirect()->route('announcements.page')->with('success', 'Announcement posted successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'category'  => 'required|string|max:100',
            'posted_by' => 'nullable|string|max:100',
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'category'  => $validated['category'],
            'posted_by' => $validated['posted_by'] ?? 'Admin',
        ]);

        return redirect()->route('announcements.page')->with('success', 'Announcement updated successfully!');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcements.page')->with('success', 'Announcement deleted successfully!');
    }
}