<div>
    <a href="{{ route('artists.show', $artist) }}">
        <div class="artistCard d-flex flex-column align-items-center justify-content-evenly">
            <img src="{{ asset('storage/' . $artist->profile_picture) }}" alt="Immagine del profilo" class="proPic">
            <h5 class="undergreen">{{ $artist->name }}</h5>
        </div>
    </a>
</div>