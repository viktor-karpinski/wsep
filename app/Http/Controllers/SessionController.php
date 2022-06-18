<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Room;
use App\Models\Session as Sesh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $user = User::where('email', '=', Session::get('user'))->first();
        $event = Event::where('slug', '=', $request->event)->first();
        $rooms = Room::where('event_id', '=', $event->id)->get();
        return view('createSession', ['user' => $user, 'event' => $event, 'rooms' => $rooms]);
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

        $request->validate([
            'title' => 'required|min:5|max:64',
            'cost' => 'required|min:1',
            'type' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'required',
            'room' => 'required',
            'speaker' => 'required|min:5|max:64',
        ]);

        $event = Event::where('slug', '=', $request->event)->first();

        $session = new Sesh();
        $session->title = $request->title;
        $session->cost = $request->cost;
        $session->type = $request->type;
        $session->speaker = $request->speaker;
        $session->room_id = $request->room;
        $session->start = $request->start;
        $session->end = $request->end;
        $session->description = $request->description;
        $session->event_id = $event->id;
        $session->save();
        return redirect()->route('event.show', [$event->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Sesh $session)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $user = User::where('email', '=', Session::get('user'))->first();
        $event = Event::where('slug', '=', $request->event)->first();
        $rooms = Room::where('event_id', '=', $event->id)->get();
        return view('editSession', ['user' => $user, 'event' => $event, 'rooms' => $rooms, 'session' => $session]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sesh $session)
    {
        if (!Session::has('user')) {
            return redirect('organizer');
        }
        $request->validate([
            'title' => 'required|min:5|max:64',
            'cost' => 'required|min:1',
            'type' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'required',
            'room' => 'required',
            'speaker' => 'required|min:5|max:64',
        ]);

        $session->title = $request->title;
        $session->cost = $request->cost;
        $session->type = $request->type;
        $session->speaker = $request->speaker;
        $session->room_id = $request->room;
        $session->start = $request->start;
        $session->end = $request->end;
        $session->description = $request->description;
        $session->save();
        return redirect()->route('event.show', [$request->event]);
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
