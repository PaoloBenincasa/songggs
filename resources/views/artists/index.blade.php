<x-layout :artist="$artist ?? null">
    <div class="pt-5 d-flex flex-column align-items-center">
        <h1 class="pt-5 fs-3 undergreen">Artists</h1>
        <div class="container">
            <div class="row justify-content-center gap-4 gap-md-5 pt-5 pb-5">
                @foreach ($artists as $artist)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <div class="d-flex flex-column align-items-center w-100">
                            <a href="{{ route('artists.show', $artist) }}" class="text-decoration-none w-100">
                                <x-artistcard :artist="$artist" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
