<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $tickets = $user->isAdmin ? Ticket::latest()->where('user_id', '<>', $user->id)->get() : $user->tickets;

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);

        if ($request->file('attachment')) {
            $this->storeAttachment($request, $ticket);
        }

        return  redirect(route('tickets.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {


        $ticket->update($request->except('attachment'));

        if ($request->has('status')) {
            // $user = User::find($ticket->user_id);
            $ticket->user->notify(new TicketUpdatedNotification($ticket));
            // return (new TicketUpdatedNotification($ticket))->toMail($ticket->user);
        }

        if ($request->file('attachment')) {
            $this->storeAttachment($request, $ticket);
        }

        return redirect(route('tickets.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect(route('tickets.index'));
    }

    protected function storeAttachment($request, $ticket)
    {
        $ext      = $request->file('attachment')->extension();
        $contents = file_get_contents($request->file('attachment'));

        $filename = Str::random(25);
        $path     = "attachments/{$ticket->user_id}/$filename.$ext";

        if ($oldAttachment = $ticket->attachment) {
            Storage::disk('public')->delete("attachments/{$ticket->user_id}/$oldAttachment");
        }

        Storage::disk('public')->put($path, $contents);
        $ticket->update(['attachment' => "$filename.$ext"]);
    }
}
