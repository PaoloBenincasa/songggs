<x-layout :artist="$loggedInArtist ?? null">
    <div class="d-flex flex-column align-items-center justify-content-center childHeight pb-5">

        <img src="{{ asset('storage/' . $artist->profile_picture) }}" alt="Foto Profilo" width="200" class="proPic">

        <h1 class="undergreen fs-3 mt-2">{{ $artist->name }}</h1>
        <small class="w-75 text-center mb-2">{{ $artist->bio }}</small>

        @php
            $publicCount = $artist->songs()->where('privacy', false)->count();
            $privateCount = $artist->songs()->where('privacy', true)->count();
        @endphp

        @if (auth()->check() && auth()->id() === $artist->user_id)
            <small class="mb-1 txtGrey">
                you have {{ $publicCount }} public {{ Str::plural('song', $publicCount) }} 
                and {{ $privateCount }} private {{ Str::plural('song', $privateCount) }} 
            </small>
        @endif

        <div class="container">
            <ul class="list-unstyled w-100">
                @foreach ($songs as $song)
                    <li class="row mb-1">
                        <div class="col-6 text-end">
                            <a class="song-link" href="{{ route('songs.show', $song->id) }}">
                                {{ $song->title }}
                            </a>
                        </div>

                        <div class="col-6 text-start">
                            @if ($song->privacy)
                                <span class="songPrivacyPriv">private</span>
                            @else
                                <span class="songPrivacyPub">public</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>



        @if (auth()->check() && auth()->id() === $artist->user_id)
            <a href="{{ route('dashboard', $artist) }}" >
                <button class="btn-contrast">
                    edit profile
                </button>
            </a>
        @endif
    </div>


</x-layout>
