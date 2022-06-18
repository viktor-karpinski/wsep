@extends('master')

@section('content')
<header class="login-header">
    <h1>
        WorldSkills Event Platform
    </h1>
</header>
<form class="login-form" method="POST" action="{{ route('organizer.store') }}">
    <div>
        <h2>
            Please sign in
        </h2>
    </div>
    
    @csrf
    <div>
        <input type="email" name="email" placeholder="Your E-Mail" autocomplete="off">
    </div>
    <div>
        <input type="password" name="password" placeholder="Your Password">
    </div>
    @if (Session::has('error'))
       <div>
            <h3>
                {{ Session::get('error') }}
            </h3>
        </div>
    @endif
    <div>
        <button type="submit">
            Sign In
        </button>
    </div>
</form>
@endsection