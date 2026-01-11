<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // Check access: Admin or Ticket Owner
        if (!Auth::user()->is_admin && $ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Comment added.');
    }
}
