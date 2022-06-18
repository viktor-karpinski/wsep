@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        Manage Events
    </h2>

    <a href="{{ route('event.create') }}">
        Create new event
    </a>
</header>
<hr>
<div class="box event-box">
    @foreach($events as $event)
        <a href="{{ route('event.show', [$event->slug]) }}" class="event">
            <h1>
                {{ $event->name }}
            </h1>
            <p>
                {{ $event->date }}
            </p>
            <hr>
            <p>
                {{ $event->registrations }}
            </p>
        </a>
    @endforeach
</div>
@endsection