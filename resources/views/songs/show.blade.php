<x-layout :artist="$song->artist">
    <div class=" d-flex flex-column align-items-center justify-content-evenly childHeight pb-5">
        <h1 class="undergreen fs-3">{{ $song->title }}</h1>

        @if ($song->artist)
            <a href="{{ route('artists.show', $song->artist) }}">
                <p class="song-link">{{ $song->artist->name }}</p>
            </a>
        @else
            <p>Artista non disponibile</p>
        @endif

        @if ($song->spotify_url)
            @php
                if (preg_match('/open\.spotify\.com\/track\/([a-zA-Z0-9]+)/', $song->spotify_url, $matches)) {
                    $spotifyEmbedUrl =
                        'https://open.spotify.com/embed/track/' . $matches[1] . '?utm_source=generator&theme=0';
                }
            @endphp

            @if (isset($spotifyEmbedUrl))
                <div class="mt-3 col-10 col-md-8 col-lg-5">
                    <iframe style="border-radius:12px" src="{{ $spotifyEmbedUrl }}" width="100%" height="152"
                        frameBorder="0" allowfullscreen=""
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"></iframe>
                </div>
            @endif
        @endif


        <div class="song-link mt-1 mb-3" data-bs-toggle="modal" data-bs-target="#studioModeModal">
            <i class="bi bi-mic-fill"></i>
            studio mode
        </div>


        @if ($song->privacy && auth()->id() !== optional($song->artist)->user_id)
            <div class="alert alert-warning">
                Questa canzone è privata. Puoi visualizzarla solo se sei l'artista che l'ha creata.
            </div>
        @else
            <h5 class="txtGrey fs-6">lyrics</h5>
            <pre class="text-center fontLexend col-10 col-md-8 col-lg-6 fs-6" style="white-space: pre-wrap;">{{ $song->lyrics }}</pre>

            @if (auth()->check() && auth()->user()->id === optional($song->artist)->user_id && $song->notes)
                <div class="mt-3 w-100 d-flex flex-column align-items-center">
                    <h5 class="txtGrey fs-6">notes</h5>
                    <div class="col-10 col-md-8 col-lg-6 bgBlack rounded">
                        <p class="p-1">{{ $song->notes }}</p>
                    </div>
                </div>
            @endif



            @if ($song->mp3_audio)
                <audio controls>
                    <source src="{{ asset('storage/' . $song->mp3_audio) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            @endif
        @endif

        <div class="d-flex gap-4">
            @if (auth()->check() && auth()->user()->id === optional($song->artist)->user_id)
                <a href="{{ route('songs.edit', $song) }}" class="mt-3 contrast-link">
                    <i class="bi bi-pencil-square"></i>
                    edit
                </a>
            @endif

            @if (auth()->check() && auth()->user()->id === optional($song->artist)->user_id)
                <form action="{{ route('songs.destroy', $song) }}" method="POST" class="mt-3"
                    onsubmit="return confirm('Are you sure you want to delete this song?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="bi bi-trash3"></i>
                        delete
                    </button>
                </form>
            @endif
        </div>

        <a href="{{ route('artists.show', $song->artist->id ?? '') }}" class="song-link mt-3">
            <i class="bi bi-box-arrow-left"></i>
            profile
        </a>

        <div class="modal fade" id="studioModeModal" tabindex="-1" aria-labelledby="studioModeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content d-flex justify-content-center align-items-center overflow-hidden">
                    <div class="modal-body text-center w-100 h-100 d-flex flex-column justify-content-center">
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal" aria-label="Close">
                        </button>

                        @php
                            // divido il testo in un array di righe
                            //  poi lo divido a sua volta in metà arrotondando per eccesso
                            //  riunisco le righe con implode mettendole in due variabili, la prima da 0 a metà, la seconda da metà in poi
                            $lyricsArray = explode("\n", $song->lyrics);
                            $half = ceil(count($lyricsArray) / 2);
                            $lyricsLeft = implode("\n", array_slice($lyricsArray, 0, $half));
                            $lyricsRight = implode("\n", array_slice($lyricsArray, $half));
                        @endphp


                        <pre class="fs-3 text-uppercase d-md-none w-100 px-1" style="white-space: pre-wrap;">{{ $song->lyrics }}</pre>


                        <div class="d-none d-md-flex flex-md-row w-100 h-100 px-5">
                            <pre class="fs-2 text-uppercase w-50 pe-md-3" style="white-space: pre-wrap;">{{ $lyricsLeft }}</pre>
                            <pre class="fs-2 text-uppercase w-50 ps-md-3" style="white-space: pre-wrap;">{{ $lyricsRight }}</pre>
                        </div>

                    </div>
                </div>
            </div>
        </div>


</x-layout>
