@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        Create ticket
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
    <form action="{{ route('ticket.store', ['event' => $event->id]) }}" method="POST">
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
            <label for="max">
                Maximum amout of tickets to be sold
            </label>
            <input type="number" min="1" name="max" id="max" value="{{ old('max') }}" autocomplete="off" placeholder="1000" required>
             @if ($errors->first('max'))
                <p class="error">
                    @error('max') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="valid_date">
                Tickets can be sold until
            </label>
            <input type="datetime-local" name="valid_date" id="valid_date" value="{{ old('valid_date') }}" required>
             @if ($errors->first('valid_date'))
                <p class="error">
                    @error('valid_date') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <button type="submit">
            Save ticket
        </button>
        <a href="{{ route('event.show', [$event->slug]) }}">
            Cancel
        </a>
    </form>
</div>
@endsection