@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        {{ $event->name }}
    </h2>

    <a href="{{ route('event.edit', [$event->slug]) }}">
        Edit event
    </a>
</header>
<hr>
<header class="box">
    <h2>
        Tickets
    </h2>

    <a href="{{ route('ticket.create', ['event' => $event->slug]) }}">
        Create new ticket
    </a>
</header>
<div class="card-box box">
    @if(count($tickets) > 0)
        @foreach ($tickets as $ticket)
            <article>
                <h2>
                    {{ $ticket->name }}
                </h2>
                <p>
                    {{ $ticket->cost }}
                </p>
                <p>
                    Available until {{ $ticket->valid_date }}
                </p>
            </article>
        @endforeach
    @else
    <div class="message-box">
        <h3>
            No Tickets
        </h3>
    </div>
    @endif
</div>

<header>
    <h2>
        Sessions
    </h2>

    <a href="{{ route('session.create', ['event' => $event->slug]) }}">
        Create new session
    </a>
</header>

<div class="table-box">
    <div>
        <p>
            Time
        </p>
        <p>
            Type
        </p>
        <p>
            Title
        </p>
        <p>
            Speaker
        </p>
        <p>
            Channel
        </p>
    </div>
    
    @if(count($sessions) > 0)
        @foreach($sessions as $session)
            <div>
                <p>
                    {{ $session->start }}
                </p>
                <p>
                    {{ $session->type }}
                </p>
                <p>
                    <a href="{{ route('session.edit', [$session->id, 'event' => $event->slug]) }}">{{ $session->title }}</a>
                </p>
                <p>
                    {{ $session->speaker }}
                </p>
                <p>
                   @foreach ( $rooms as $room )
                        @if ( $session->room_id == $room->id ) 
                            {{ $room->name }}
                        @endif
                    @endforeach
                </p>
            </div>
        @endforeach
</div>
    @else
</div>
<div class="message-box">
    <h3>
        No Rooms
    </h3>
</div>
    @endif
   
<header>
    <h2>
        Channels
    </h2>

    <a href="{{ route('channel.create', ['event' => $event->slug]) }}">
        Create new channel
    </a>
</header>
<div class="card-box box">
    @if(count($channels) > 0)
        @foreach ($channels as $channel)
            <article>
                <h2>
                    {{ $channel->name }}
                </h2>
                <p>
                    10 sessions, 1 room
                </p>
            </article>
        @endforeach
    @else
    <div class="message-box">
        <h3>
            No Channels
        </h3>
    </div>
    @endif
</div>

<header>
    <h2>
        Rooms
    </h2>

    <a href="{{ route('room.create', ['event' => $event->slug]) }}">
        Create new room
    </a>
</header>

<div class="table-box">
    <div>
        <p>
            Name
        </p>
        <p>
            Capacity
        </p>
    </div>
    @if(count($rooms) > 0)
        @foreach($rooms as $room)
            <div>
                <p>
                    {{ $room->name }}
                </p>
                <p>
                    {{ $room->capacity }}
                </p>
            </div>
        @endforeach
</div>
    @else
</div>
<div class="message-box">
    <h3>
        No Rooms
    </h3>
</div>
    @endif
@endsection