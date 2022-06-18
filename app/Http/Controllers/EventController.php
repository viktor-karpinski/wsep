<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\User;
use App\Models\Event;
use App\Models\Room;
use App\Models\Session as Sesh;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $user = User::where('email', '=', Session::get('user'))->first();
        $events = Event::where('user_id', '=', $user->id)->get();
        return view('dashboard', ['user' => $user, 'events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $this->isLoggedIn();
        $user = User::where('email', '=', Session::get('user'))->first();
        return view('createEvent', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $user = User::where('email', '=', Session::get('user'))->first();
        $request->validate([
            'name' => 'required|min:5|max:64',
            'slug' => 'required|unique:events|min:1|max:64',
            'date' => 'required'
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->slug = $request->slug;
        $event->date = $request->date;
        $event->user_id = $user->id;
        $event->registrations = 0;
        $event->save();
        return redirect('/event/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $user = User::where('email', '=', Session::get('user'))->first();
        $tickets = Ticket::where('event_id', '=', $event->id)->get();
        $channels = Channel::where('event_id', '=', $event->id)->get();
        $rooms = Room::where('event_id', '=', $event->id)->get();
        $sessions = Sesh::where('event_id', '=', $event->id)->get();
        return view('event', [
            'user' => $user,
            'event' => $event,
            'tickets' => $tickets,
            'channels' => $channels,
            'rooms' => $rooms,
            'sessions' => $sessions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $user = User::where('email', '=', Session::get('user'))->first();
        return view('editEvent', ['user' => $user, 'event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $request->validate([
            'name' => 'required|min:5|max:64',
            'date' => 'required',
        ]);
        if ($request->slug !== $event->slug) {
            $request->validate([
                'slug' => 'required|unique:events|min:1|max:64',
            ]);
            $event->slug = $request->slug;
        }
        $event->name = $request->name;
        $event->date = $request->date;
        $event->save();
        return redirect()->route('event.show', [$event->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
