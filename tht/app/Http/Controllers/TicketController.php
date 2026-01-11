<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            $tickets = Ticket::with(['user', 'category'])->latest()->get();
        } else {
            $tickets = Ticket::with(['user', 'category'])->where('user_id', $user->id)->latest()->get();
        }

        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tickets.create', compact('categories')); // Changed from tickets.index to tickets.create
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Sesuai ketentuan: Image max 2MB, format jpg/png)
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', 
            'description' => 'required|string',
            'location' => 'required|string',
            'image' => 'required|image|mimes:jpg,png|max:2048', // Validasi Foto
        ]);

        // 2. Upload Foto menggunakan Storage Facade
        // Kita gunakan disk 'public' agar bisa diakses via browser (perlu symlink)
        $path = null;
        if ($request->hasFile('image')) {
            // Simpan file ke folder: storage/app/public/tickets
            $path = Storage::disk('public')->put('tickets', $request->file('image'));
        }

        // 3. Simpan ke Database
        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'image_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function show(Ticket $ticket)
    {
        // Check authorization (unless admin)
        if (!Auth::user()->is_admin && $ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['comments.user', 'category']);
        return view('tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Only admin handles status updates
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully!');
    }
}
