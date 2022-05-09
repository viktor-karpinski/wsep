@extends('master')

@section('content')
    <main>

        <aside id="menu-box">
            <header>
                <h1>
                    Event Platform
                </h1>
            </header>
            <menu>
                <a href="{{ route('viewDashboard') }}">
                    Manage Events
                </a>
            </menu>
        </aside>

        <section id="main">
            <header id="header">
                <h1>
                    World Skills
                </h1>

                <aside>
                    <h2>
                        {{ $user->name }}
                    </h2>
                    <a href="{{ route('logout') }}">
                        Sign out
                    </a>
                </aside>
            </header>

            <article id="content">
                @yield('morecontent')
                <!--<header>
                    <h2>
                        Manage Events
                    </h2>

                    <a href="#">
                        Create new event
                    </a>
                </header>
                <hr>
                
                <header class="box">
                    <h2>
                        Tickets
                    </h2>

                    <a href="#">
                        Create new ticket
                    </a>
                </header>
                <div class="card-box box">
                    <article>
                        <h2>
                            Ticket 1
                        </h2>
                        <p>
                            100€
                        </p>
                        <p>
                            Available until tomorrow
                        </p>
                    </article>

                    <article>
                        <h2>
                            Ticket 1
                        </h2>
                        <p>
                            100€
                        </p>
                        <p>
                            Available until tomorrow
                        </p>
                    </article>

                    <article>
                        <h2>
                            Ticket 1
                        </h2>
                        <p>
                            100€
                        </p>
                        <p>
                            Available until tomorrow
                        </p>
                    </article>

                    <article>
                        <h2>
                            Ticket 1
                        </h2>
                        <p>
                            100€
                        </p>
                        <p>
                            Available until tomorrow
                        </p>
                    </article>

                    <article>
                        <h2>
                            Ticket 1
                        </h2>
                        <p>
                            100€
                        </p>
                        <p>
                            Available until tomorrow
                        </p>
                    </article>
                </div>

                <header>
                    <h2>
                        Sessions
                    </h2>

                    <a href="#">
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
                    <div>
                        <p>
                            6:30 - 10:00
                        </p>
                        <p>
                            Talk
                        </p>
                        <p>
                            Keynote
                        </p>
                        <p>
                            Joe Rogan
                        </p>
                        <p>
                            Main / Room A
                        </p>
                    </div>
                    <div>
                        <p>
                            8:30 - 12:00
                        </p>
                        <p>
                            Talk
                        </p>
                        <p>
                            BJJ
                        </p>
                        <p>
                            Alex Jones
                        </p>
                        <p>
                            Main / Room B
                        </p>
                    </div>
                    <div>
                        <p>
                            8:30 - 12:00
                        </p>
                        <p>
                            work out
                        </p>
                        <p>
                            DG
                        </p>
                        <p>
                            Stefan Burnett
                        </p>
                        <p>
                            Side / Room D
                        </p>
                    </div>
                </div>

                <header>
                    <h2>
                        Channels
                    </h2>

                    <a href="#">
                        Create new channel
                    </a>
                </header>
                <div class="card-box box">
                    <article>
                        <h2>
                            Main
                        </h2>
                        <p>
                            3 sessions, 2 rooms
                        </p>
                    </article>

                    <article>
                        <h2>
                            Side
                        </h2>
                        <p>
                            10 sessions, 1 room
                        </p>
                    </article>

                </div>

                <header>
                    <h2>
                        Rooms
                    </h2>

                    <a href="#">
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
                    <div>
                        <p>
                            Room A
                        </p>
                        <p>
                            10000
                        </p>
                    </div>
                    <div>
                        <p>
                            Room B
                        </p>
                        <p>
                            50000
                        </p>
                    </div>
                    <div>
                        <p>
                            Room C
                        </p>
                        <p>
                            4
                        </p>
                    </div>
                </div>-->
            </article>
        </section>

    </main>
@endsection