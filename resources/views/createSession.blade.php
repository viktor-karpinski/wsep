@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        Create session
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
    <form action="{{ route('session.store', ['event' => $event->slug]) }}" method="POST">
        @csrf
        <div>
             <label for="type">
                Type
            </label>
            <select name="type" id="type" value="{{ old('type') }}" autocomplete="off" placeholder="Type" required>
                <option value="Workshop">
                    Workshop
                </option>
                <option value="Talk">
                    Talk
                </option>
            </select>
            @if ($errors->first('type'))
                <p class="error">
                    @error('type') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="title">
                Title
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" autocomplete="off" placeholder="Title" required>
            @if ($errors->first('title'))
                <p class="error">
                    @error('title') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="speaker">
                Speaker
            </label>
            <input type="text" name="speaker" id="speaker" value="{{ old('speaker') }}" autocomplete="off" placeholder="Speaker" required>
             @if ($errors->first('speaker'))
                <p class="error">
                    @error('speaker') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
             <label for="room">
                Room
            </label>
            <select name="room" id="room" value="{{ old('room') }}" autocomplete="off" placeholder="Room" required>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->first('type'))
                <p class="error">
                    @error('type') {{ $message }} @enderror
                </p>
            @endif
        </div>
         <div>
            <label for="cost">
                Cost
            </label>
            <input type="number" min="0" name="cost" id="cost" value="{{ old('cost') }}" autocomplete="off" placeholder="Cost" required>
             @if ($errors->first('cost'))
                <p class="error">
                    @error('cost') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="start">
                Start
            </label>
            <input type="datetime-local" name="start" id="start" value="{{ old('start') }}" required>
             @if ($errors->first('start'))
                <p class="error">
                    @error('start') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="end">
                End
            </label>
            <input type="datetime-local" name="end" id="end" value="{{ old('end') }}" required>
             @if ($errors->first('end'))
                <p class="error">
                    @error('end') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="description">
                Description
            </label>
            <textarea name="description" id="description" placeholder="Description" required>{{ old('description') }}</textarea>
             @if ($errors->first('description'))
                <p class="error">
                    @error('description') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <button type="submit">
            Save session
        </button>
        <a href="{{ route('event.show', [$event->slug]) }}">
            Cancel
        </a>
    </form>
</div>
@endsection