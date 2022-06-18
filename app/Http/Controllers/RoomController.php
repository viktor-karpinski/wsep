<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Event;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
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
        $channels = Channel::where('event_id', '=', $event->id)->get();
        return view('createRoom', ['user' => $user, 'event' => $event, 'channels' => $channels]);
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
            'name' => 'required|min:5|max:64',
            'capacity' => 'required|min:1',
            'channel' => 'required'
        ]);

        $event = Event::where('slug', '=', $request->event)->first();

        $room = new Room();
        $room->name = $request->name;
        $room->channel_id = $request->channel;
        $room->capacity = $request->capacity;
        $room->event_id = $event->id;
        $room->save();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
