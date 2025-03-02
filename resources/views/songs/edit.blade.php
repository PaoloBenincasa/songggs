<x-layout :artist="$song->artist">
    <div class="container">
        <h2 class="pt-5">Modifica Canzone</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('songs.update', $song) }}" method="POST" class="pb-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label txtGrey">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $song->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="lyrics" class="form-label txtGrey">Lyrics</label>
                <textarea rows="25" name="lyrics" id="lyrics" class="form-control">{{ old('lyrics', $song->lyrics) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label txtGrey">Notes</label>
                <textarea name="notes" id="notes" class="form-control">{{ old('notes', $song->notes) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="spotify_url" class="form-label txtGrey">Spotify link</label>
                <input type="url" name="spotify_url" id="spotify_url" class="form-control" value="{{ old('spotify_url', $song->spotify_url) }}">
            </div>

            <div class="mb-3">
                <label for="mp3_audio" class="form-label txtGrey">MP3</label>
                <input type="file" name="mp3_audio" id="mp3_audio" class="form-control">
                @if ($song->mp3_audio)
                    <p class="mt-2">File attuale: <a href="{{ asset('storage/' . $song->mp3_audio) }}" target="_blank">{{ basename($song->mp3_audio) }}</a></p>
                @endif
            </div>

            <div class="row mb-3 w-100">
                <div class="col-12 col-md-8 col-lg-6 text-start">
                    <div class="form-check">
                        <input type="radio" name="privacy" id="privacy_private" class="form-check-input" value="1"
                            {{ old('privacy', $song->privacy) == 1 ? 'checked' : '' }}>
                        <label for="privacy_private" class="form-check-label">Private</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="privacy" id="privacy_public" class="form-check-input" value="0"
                            {{ old('privacy', $song->privacy) == 0 ? 'checked' : '' }}>
                        <label for="privacy_public" class="form-check-label">Public</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-green">Update Song</button>
            <a href="{{ route('songs.show', $song) }}" class="btn btn-secondary">Cancel</a>
        </form>

        
    </div>
</x-layout>

