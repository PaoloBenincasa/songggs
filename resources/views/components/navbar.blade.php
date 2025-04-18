@props(['artist'])

<nav class="navbar fixed-top p-1">

    <div class="list-unstyled d-flex justify-content-evenly align-items-center h-100 w-100 nav-inner">
        <a href="{{ route('welcome') }}">
            <li class="d-flex flex-column align-items-center navlink">
                <i class="bi bi-house-fill"></i>
                home
            </li>
        </a>
        <a href="{{ route('search') }}">
            <li class="d-flex flex-column align-items-center navlink">
                <i class="bi bi-search"></i>
                search
            </li>
        </a>
        <a href="{{ route('songs.create') }}">
            <li class="d-flex flex-column align-items-center navlink">
                <i class="bi bi-pen-fill"></i>
                write
            </li>
        </a>
        <a href="{{ route('artists.index') }}">
            <li class="d-flex flex-column align-items-center navlink">
                <i class="bi bi-file-music-fill"></i>
                artists
            </li>
        </a>

        <div class="dropdown">
            <button class=" dropdown-toggle d-flex align-items-center navlink" type="button" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                @auth
                    <div class="d-flex flex-column">
                        <i class="bi bi-person-badge-fill"></i>
                        @php
                            $name = Auth::user()->name;
                            $shortName = strlen($name) > 7 ? substr($name, 0, 5) . '...' : $name;
                        @endphp
                        <span>{{ $shortName }}</span>
                    </div>
                @endauth
                @guest
                    <div class="d-flex flex-column">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>user</span>
                    </div>
                @endguest
            </button>

            <ul class="dropdown-menu">

                @auth
                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            dashboard
                        </a>
                    </li>
                    @if ($artist)
                        <li>
                            <a class="dropdown-item" href="{{ route('artists.show', ['artist' => $artist->id]) }}">
                                profile
                            </a>
                        </li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">logout</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li><a class="dropdown-item" href="{{ route('login') }}">log in</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">sign up</a></li>
                @endguest
            </ul>

        </div>




    </div>

</nav>
