<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\NoticeComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeInteractionController extends Controller
{
    public function index(Notice $notice)
    {
        $comments = $notice->comments()->with('user')->paginate(10);

        return view('notice_board.comments', [
            'notice' => $notice,
            'comments' => $comments,
        ]);
    }

    public function toggleLike(Notice $notice)
    {
        $userId = Auth::id();

        $existing = $notice->likes()->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();
        } else {
            $notice->likes()->create(['user_id' => $userId]);
        }

        return redirect()->back();
    }

    public function storeComment(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $notice->comments()->create([
            'user_id' => Auth::id(),
            'body' => $data['body'],
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    public function destroyComment(NoticeComment $comment)
    {
        $user = Auth::user();
        $allowed = $user?->hasRole('admin') || $user?->can('notices.manage');

        abort_unless($allowed, 403);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
