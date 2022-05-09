<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Channel;
use App\Models\Session as Sesh;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewDashboard()
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            if ($user->privileges === 1) {
                $events = Event::where('user_id', '=', $user->id)->get();
                return view('dashboard', ['user' => $user, 'events' => $events]);
            }
        }
        return redirect('login/organizer');
    }

    public function viewEvent($slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
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
        }
        return redirect('dashboard');
    }

    public function viewCreateEvent()
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            return view('createEvent', ['user' => $user]);
        }
        return redirect('login/organizer');
    }

    public function createEvent(Request $req)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            if ($user->privileges === 1) {
                $req->validate([
                    'name' => 'required|min:5|max:64',
                    'slug' => 'required|unique:events|min:1|max:64',
                    'date' => 'required'
                ]);

                $event = new Event();
                $event->name = htmlspecialchars($req->name);
                $event->slug = htmlspecialchars($req->slug);
                $event->date = htmlspecialchars($req->date);
                $event->user_id = $user->id;
                $event->registrations = 0;

                if ($event->save()) {
                    return redirect('dashboard');
                }
                return back()->with(['message' => 'couldn\'t save event...']);
            }
        }
        return redirect('login/organizer');
    }

    public function viewEditEvent($slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                return view('editEvent', ['user' => $user, 'event' => $event]);
            }
        }
        return redirect('dashboard');
    }

    public function editEvent(Request $req, $slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $req->validate([
                    'name' => 'required|min:5|max:64',
                    'date' => 'required'
                ]);

                if ($event->slug !== $req->slug) {
                    $req->validate([
                        'slug' => 'required|unique:events|min:1|max:64',
                    ]);
                }

                $event->name = htmlspecialchars($req->name);
                $event->slug = htmlspecialchars($req->slug);
                $event->date = htmlspecialchars($req->date);

                if ($event->save()) {
                    return redirect('event/' . $slug);
                }
                return back()->with(['message' => 'couldn\'t save event...']);
            }
        }
        return redirect('login/organizer');
    }

    public function viewCreateTicket($slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                return view('createTicket', ['user' => $user, 'event' => $event]);
            }
        }
        return redirect('dashboard');
    }

    public function createTicket(Request $req, $slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $req->validate([
                    'name' => 'required|min:5|max:64',
                    'cost' => 'required|min:1|',
                    'max' => 'required|min:1',
                    'valid_date' => 'required'
                ]);

                $ticket = new Ticket();
                $ticket->name = htmlspecialchars($req->name);
                $ticket->cost = htmlspecialchars($req->cost);
                $ticket->max = htmlspecialchars($req->max);
                $ticket->valid_date = htmlspecialchars($req->valid_date);
                $ticket->event_id = $event->id;

                if ($ticket->save()) {
                    return redirect('event/' . $event->slug);
                }
                return back()->with(['message' => 'couldn\'t save ticket...']);
            }
        }
        return redirect('dashboard');
    }

    public function viewCreateSession($slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $rooms = Room::where('event_id', '=', $event->id)->get();
                return view('createSession', ['user' => $user, 'event' => $event, 'rooms' => $rooms]);
            }
        }
        return redirect('dashboard');
    }

    public function createSession(Request $req, $slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $req->validate([
                    'title' => 'required|min:5|max:64',
                    'cost' => 'required|min:1',
                    'type' => 'required',
                    'start' => 'required',
                    'end' => 'required',
                    'description' => 'required',
                    'room' => 'required',
                    'speaker' => 'required|min:5|max:64',
                ]);

                $session = new Sesh();
                $session->title = htmlspecialchars($req->title);
                $session->cost = htmlspecialchars($req->cost);
                $session->type = htmlspecialchars($req->type);
                $session->speaker = htmlspecialchars($req->speaker);
                $session->room_id = htmlspecialchars($req->room);
                $session->start = htmlspecialchars($req->start);
                $session->end = htmlspecialchars($req->end);
                $session->description = htmlspecialchars($req->description);
                $session->event_id = $event->id;

                if ($session->save()) {
                    return redirect('event/' . $event->slug);
                }
                return back()->with(['message' => 'couldn\'t save session...']);
            }
        }
        return redirect('dashboard');
    }

    public function viewEditSession($id)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $session = Sesh::where('id', '=', $id)->first();
            $event = Event::where('id', '=', $session->event_id)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $rooms = Room::where('event_id', '=', $event->id)->get();
                return view('editSession', ['user' => $user, 'event' => $event, 'rooms' => $rooms, 'session' => $session]);
            }
        }
        return redirect('dashboard');
    }

    public function editSession(Request $req, $id)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $session = Sesh::where('id', '=', $id)->first();
            $event = Event::where('id', '=', $session->event_id)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $req->validate([
                    'title' => 'required|min:5|max:64',
                    'cost' => 'required|min:1',
                    'type' => 'required',
                    'start' => 'required',
                    'end' => 'required',
                    'description' => 'required',
                    'room' => 'required',
                    'speaker' => 'required|min:5|max:64',
                ]);

                $session->title = htmlspecialchars($req->title);
                $session->cost = htmlspecialchars($req->cost);
                $session->type = htmlspecialchars($req->type);
                $session->speaker = htmlspecialchars($req->speaker);
                $session->room_id = htmlspecialchars($req->room);
                $session->start = htmlspecialchars($req->start);
                $session->end = htmlspecialchars($req->end);
                $session->description = htmlspecialchars($req->description);

                if ($session->save()) {
                    return redirect('event/' . $event->slug);
                }
                return back()->with(['message' => 'couldn\'t save session...']);
            }
        }
        return redirect('dashboard');
    }

    public function viewCreateChannel($slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                return view('createChannel', ['user' => $user, 'event' => $event]);
            }
        }
        return redirect('dashboard');
    }

    public function createChannel(Request $req, $slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $req->validate([
                    'name' => 'required|min:5|max:64',
                ]);

                $channel = new Channel();
                $channel->name = htmlspecialchars($req->name);
                $channel->event_id = $event->id;

                if ($channel->save()) {
                    return redirect('event/' . $event->slug);
                }
                return back()->with(['message' => 'couldn\'t save channel...']);
            }
        }
        return redirect('dashboard');
    }

    public function viewCreateRoom($slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $channels = Channel::where('event_id', '=', $event->id)->get();
                return view('createRoom', ['user' => $user, 'event' => $event, 'channels' => $channels]);
            }
        }
        return redirect('dashboard');
    }

    public function createRoom(Request $req, $slug)
    {
        if ($this->isLoggedIn()) {
            $user = User::where('email', '=', Session::get('user'))->first();
            $event = Event::where('slug', '=', $slug)->first();
            if ($user->privileges === 1 && $event->user_id === $user->id) {
                $req->validate([
                    'name' => 'required|min:5|max:64',
                    'capacity' => 'required|min:1',
                    'channel' => 'required'
                ]);

                $room = new Room();
                $room->name = htmlspecialchars($req->name);
                $room->channel_id = htmlspecialchars($req->channel);
                $room->capacity = htmlspecialchars($req->capacity);
                $room->event_id = $event->id;

                if ($room->save()) {
                    return redirect('event/' . $event->slug);
                }
                return back()->with(['message' => 'couldn\'t save room...']);
            }
        }
        return redirect('dashboard');
    }

    public function viewLogin($who = 'user')
    {
        $this->justLogout();
        if ($who === 'organizer') {

            return view('organizerLogin');
        }
        return view('login');
    }

    public function login(Request $req, $who = 'user')
    {
        if ($who === 'organizer') {
            $user = User::where([
                ['email', '=', $req->email],
                ['privileges', '=', '1']
            ])->get();
            if (count($user) > 0) {
                if (Hash::check($req->password, $user[0]->password)) {
                    Session::put('user', $req->email);
                    return redirect('dashboard');
                }
            }
        }
        return back()->with(['error' => 'Email or password not correct']);
    }

    public function isLoggedIn()
    {
        if (Session::has('user')) {
            return true;
        }
        return false;
    }

    public function justLogout()
    {
        Session::pull('user');
    }

    public function logout()
    {
        $this->justLogout();
        return redirect('login/organizer');
    }
}
