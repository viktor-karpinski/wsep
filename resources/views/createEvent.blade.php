@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        Create event
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
    <form action="{{ route('createEvent') }}" method="POST">
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
            <label for="slug">
                Cost
            </label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" autocomplete="off" placeholder="Slug" required>
             @if ($errors->first('slug'))
                <p class="error">
                    @error('slug') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <div>
            <label for="date">
                Date
            </label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" required>
             @if ($errors->first('date'))
                <p class="error">
                    @error('date') {{ $message }} @enderror
                </p>
            @endif
        </div>
        <button type="submit">
            Save Event
        </button>
        <a href="{{ route('viewDashboard') }}">
            Cancel
        </a>
    </form>
</div>
@endsection