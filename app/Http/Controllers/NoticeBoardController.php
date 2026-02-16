<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoticeBoardController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();

        $notices = Notice::query()
            ->orderByDesc('created_at')
            ->get();

        return view('notice_board.index', compact('notices'));
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'banner' => 'nullable|image|max:4096',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['created_by'] = Auth::id();
        $data['banner_path'] = $this->storeBanner($request);

        Notice::create($data);

        return redirect()->back()->with('success', 'Notice created.');
    }

    public function update(Request $request, Notice $notice)
    {
        $this->authorizeAccess();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'banner' => 'nullable|image|max:4096',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['banner_path'] = $this->storeBanner($request, $notice->banner_path);

        $notice->update($data);

        return redirect()->back()->with('success', 'Notice updated.');
    }

    public function destroy(Notice $notice)
    {
        $this->authorizeAccess();

        if ($notice->banner_path) {
            Storage::disk('public')->delete($notice->banner_path);
        }

        $notice->delete();

        return redirect()->back()->with('success', 'Notice deleted.');
    }

    private function authorizeAccess(): void
    {
        $user = Auth::user();
        $allowed = $user?->hasRole('admin') || $user?->can('notices.manage');

        abort_unless($allowed, 403);
    }

    private function storeBanner(Request $request, ?string $existingPath = null): ?string
    {
        if (!$request->hasFile('banner')) {
            return $existingPath;
        }

        if ($existingPath) {
            Storage::disk('public')->delete($existingPath);
        }

        return $request->file('banner')->store('notices', 'public');
    }
}
