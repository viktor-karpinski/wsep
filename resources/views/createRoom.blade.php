@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        Create room
    </h2>
</header>
<hr>
@if (session('message')) 
    <div class="message-box">
        <h2>
            {{ session('message') }}
        </h2>
    </div>
@endif
<div class="box">
    <form action="{{ route('room.store', ['event' => $event->slug]) }}" method="POST">
        @csrf
        <div>
            <label for="name">
                Name
            </label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="off" placeholder="Name" required>
            @if ($errors->first('name'))
                <p class="error">
                    @error('name') {{ $message }} @enderror
                </p>
            @endif
        </div>

        <div>
            <label for="channel">
                Channel
            </label>
            <select name="channel" id="channel" value="{{ old('channel') }}" autocomplete="off" placeholder="Channel" required>
                @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}">
                        {{ $channel->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->first('nachannelme'))
                <p class="error">
                    @error('channel') {{ $message }} @enderror
                </p>
            @endif
        </div>

        <div>
            <label for="capacity">
                Capacity
            </label>
            <input type="number" min="0" name="capacity" id="capacity" value="{{ old('capacity') }}" autocomplete="off" placeholder="Capacity" required>
             @if ($errors->first('capacity'))
                <p class="error">
                    @error('capacity') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <button type="submit">
            Save room
        </button>
        <a href="{{ route('event.show', [$event->slug]) }}">
            Cancel
        </a>
    </form>
</div>
@endsection