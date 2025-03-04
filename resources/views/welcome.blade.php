<x-layout>
    <header class="hero gap-2 pe-5 pb-5 ">
        <div class='hero-content p-3'>
            <h4>
                <span>
                    <h1 class="mb-0 undergreen">
                        <i>Songggs</i>
                    </h1>
                </span>
                your personal musical diary
            </h4>
            <h6>
                Ever struggled to keep track of the music you're working on?
                This is the place for you! Work on your lyrics and store your demos.
            </h6>
            <div class="d-flex flex-column">
                <a href={{ route('songs.create', []) }}>
                    <button class="btn-contrast">Start writing!</button>
                </a>
                @if (!auth()->check())
                    <small>
                        don't have an account yet?
                        <a href={{ route('register', []) }}>
                            <button class="btn-green">
                                sign up!
                            </button>
                        </a>
                    </small>
                @endif
            </div>
        </div>
    </header>
    <main class="d-flex flex-column align-items-center">


        <div class="container-fluid d-flex flex-column align-items-center pb-4">

            <h4 class="mt-5">latest artists</h4>
            <a href="{{ route('artists.index') }}" class="contrast-link mt-1">check all artists</a>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    @foreach ($latestArtists as $artist)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <x-artistcard :artist="$artist" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="container-fluid d-flex flex-column align-items-center bgBlack">

            <h4 class="mt-5">songs</h4>
            <div class="container mb-5">
                <ul class="list-unstyled mt-5 w-100">
                    @foreach ($songs as $song)
                        <li class="row mb-2">
                            <div class="col-6 text-end">
                                <a class="song-link" href="{{ route('songs.show', $song) }}">{{ $song->title }}</a>
                            </div>
                            <div class="col-6">
                                <a class="song-link"
                                    href="{{ route('artists.show', $song->artist) }}">{{ $song->artist->name }}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </main>


</x-layout>
