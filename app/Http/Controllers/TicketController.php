<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $tickets = auth()->user()->tickets;

            if ($tickets->isNotEmpty()) {
                return view('tickets.index', compact('tickets'));
            }

            return view('tickets.index', compact('tickets'));

        }

        // Jika pengguna belum login, tampilkan informasi
        return view('tickets.auth');
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Buat tiket baru
        $ticket = auth()->user()->tickets()->create([
            'title' => $request->title,
            'status' => 'open',
        ]);

        // Tambahkan pesan default ke tabel ticket_messages
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'user',
            'sender_id' => auth()->id(),
            'message' => $request->message ,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        return view('tickets.show', compact('ticket'));
    }
}
