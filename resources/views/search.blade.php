<x-layout :artist="$loggedInArtist ?? null">
    <div class="container pt-5 ">
        <h1 class="pt-5 fs-3 undergreen">search</h1>

        <form action="{{ route('search') }}" method="GET" class="mt-4">
            <div class="input-group w-75 w-md-50">
                <input type="text" name="search" class="form-control" placeholder="search for songs, lyrics, artists..."
                    value="{{ $search }}">
                <button type="submit" class="btn-green">search</button>
            </div>
        </form>

        @if ($search)
            <ul class="mt-3">
                    @foreach ($artists as $artist)
                        <a href="{{ route('artists.show', $artist) }}">
                                <li>
                                    <p class="song-link">
                                        {{ $artist->name }}
                                    </p>
                                </li>
                            </a>
                    @endforeach
                    @foreach ($songs as $song)
                        <a href="{{ route('songs.show', $song) }}">
                                <li>
                                    <p class="song-link">
                                        {{ $song->title }}
                                    </p>
                                </li>
                            </a>
                    @endforeach
              
            </ul>
        @endif
    </div>
</x-layout>
