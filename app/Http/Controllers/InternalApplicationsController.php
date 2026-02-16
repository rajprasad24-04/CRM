<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class InternalApplicationsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $notices = Notice::query()
            ->where('is_active', true)
            ->with([
                'comments' => function ($query) {
                    $query->latest()->take(3)->with('user');
                },
                'likes' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])
            ->withCount('likes')
            ->withCount('comments')
            ->orderByDesc('created_at')
            ->get();

        return view('internal_apps', [
            'notices' => $notices,
            'userName' => Auth::user()->name ?? null,
            'userId' => $userId,
        ]);
    }
}
