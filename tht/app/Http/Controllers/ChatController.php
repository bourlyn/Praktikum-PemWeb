<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of tickets to discuss.
     */
    public function index()
    {
        $user = Auth::user();

        // If admin, show all tickets. If student, only show their own.
        // We can check this based on logic, or just reuse the logic from TicketController.
        // But let's keep it simple.
        
        if ($user->is_admin) {
            $tickets = Ticket::with('user', 'category')->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)->with('category')->latest()->get();
        }

        return view('chats.index', compact('tickets'));
    }
}
