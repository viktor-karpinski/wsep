@extends('dashboardpreset')

@section('morecontent')
<header>
    <h2>
        Create channel
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
    <form action="{{ route('createChannel', [$event->slug]) }}" method="POST">
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
        
        <button type="submit">
            Save channel
        </button>
        <a href="{{ route('viewEvent', [$event->slug]) }}">
            Cancel
        </a>
    </form>
</div>
@endsection