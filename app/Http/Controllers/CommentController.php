<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'commentable_type' => 'required|string|in:App\Models\Event,App\Models\News,App\Models\AlumniStory,App\Models\Publication,App\Models\PressRelease',
            'commentable_id' => 'required|integer',
            'body' => 'required|string|max:2000',
        ]);

        if (! Auth::check()) {
            return back()->with('error', 'You must be logged in to comment.');
        }

        $commentableClass = $request->input('commentable_type');
        $commentable = $commentableClass::findOrFail($request->input('commentable_id'));

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'commentable_type' => $commentableClass,
            'commentable_id' => $commentable->id,
            'body' => $request->input('body'),
            'is_approved' => true,
        ]);

        // Redirect back to the referring page
        $url = $request->headers->get('referer', url('/'));
        $commentCount = $commentable->comments()->approved()->count();

        return redirect($url . '#comments')->with('success', 'Comment posted! (' . $commentCount . ' comments)');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        if (! $comment->canBeDeleted()) {
            abort(403);
        }

        $commentable = $comment->commentable;
        $comment->delete();

        $url = url()->previous();
        $commentCount = $commentable->comments()->approved()->count();

        return redirect($url . '#comments')->with('success', 'Comment deleted. (' . $commentCount . ' comments)');
    }
}
