<x-layout :artist="$artist">
    <div class="container childHeight pb-5">
        <h1 class="text-center undergreen fs-3">write your song!</h1>
        <div>

            <!-- Messaggi di errore -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('songs.store') }}" method="POST" class="d-flex flex-column align-items-center"
                enctype="multipart/form-data">
                @csrf

                <!-- titolo -->
                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto">
                        <label for="title" class="form-label txtGrey">title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title') }}" required>
                    </div>
                </div>
                {{-- testo --}}
                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto">
                        <label for="lyrics" class="form-label txtGrey">lyrics</label>
                        <textarea name="lyrics" id="lyrics" class="form-control" rows="30">{{ old('lyrics') }}</textarea>
                    </div>
                </div>

                <!-- appunti sulla canzone -->
                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto"> 
                        <label for="notes" class="form-label txtGrey">notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="5">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- link a spotify -->
                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto"> 
                        <label for="spotify_url" class="form-label txtGrey">spotify link</label>
                        <input type="url" name="spotify_url" id="spotify_url" class="form-control"
                            value="{{ old('spotify_url') }}" placeholder="paste the url of the song here">
                    </div>
                </div>

                <!-- MP3 -->
                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto"> 
                        <label for="mp3_audio" class="form-label txtGrey">MP3</label>
                        <input type="file" name="mp3_audio" id="mp3_audio" class="form-control">
                    </div>
                </div>

                {{-- logica della privacy --}}
                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto text-start"> 
                        <div class="form-check">
                            <input type="radio" name="privacy" id="privacy_private" class="form-check-input"
                                value="1" {{ old('privacy') == '1' ? 'checked' : '' }}>
                            <label for="privacy_private" class="form-check-label">private</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="privacy" id="privacy_public" class="form-check-input"
                                value="0" {{ old('privacy') == '0' ? 'checked' : '' }}>
                            <label for="privacy_public" class="form-check-label">public</label>
                        </div>
                    </div>
                </div>



                <div class="row mb-3 w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto">
                        <button type="submit" class="btn-green w-100">save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
