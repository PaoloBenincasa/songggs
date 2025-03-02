{{-- <x-layout>
    <div class="container vh-100 childHeight d-flex flex-column align-items-center justify-content-center w-100">
        <div class="w-75 p-3">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($artist)
               

                <h2>edit your profile</h2>
                <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column align-items-start">
                    @csrf
                    @method('PUT')
                    <div class="w-100 d-flex flex-column mb-2">
                        <label for="name" class="txtGrey">Name</label>
                        <input type="text" name="name" value="{{ $artist->name }}" required class="w-25 p-1">
                    </div>
                    <div class="d-flex flex-column w-100 mb-2">
                        <label for="bio" class="txtGrey">Bio</label>
                        <textarea name="bio" cols="30" rows="10" class="w-100 p-1">{{ $artist->bio }}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-2">
                        <label for="profile_picture" class="txtGrey">Profile picture</label>
                        <input type="file" name="profile_picture" accept="image/*">
                    </div>
                    <button type="submit" class="btn-contrast">update artist</button>
                </form>


               

                <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Are you sure you want to delete this artist?')">
                        delete artist
                    </button>
                </form>
            @else
                <h2>Crea il tuo Artista</h2>
                <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="profile_picture">Immagine del profilo</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control"
                            accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Salva Artista</button>
                </form>
            @endif
        </div>
    </div>
</x-layout> --}}

<x-layout>
    <div class="container h-100 childHeight d-flex flex-column align-items-center justify-content-center w-100">
        <div class="w-100 w-md-75 p-3"> <!-- Aggiunto w-md-75 per ridurre la larghezza su schermi medi e grandi -->

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($artist)
                <!-- Artista esistente, visualizza i dettagli -->
                <h1 class="fs-3 undergreen">edit your profile</h1>
                <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column align-items-start w-100"> <!-- Aggiunto w-100 -->
                    @csrf
                    @method('PUT')
                    <div class="w-100 d-flex flex-column mb-3"> <!-- Aggiunto mb-3 per margine inferiore -->
                        <label for="name" class="txtGrey">Name</label>
                        <input type="text" name="name" value="{{ $artist->name }}" required class="w-100 w-md-25 p-1"> <!-- Aggiunto w-100 w-md-25 -->
                    </div>
                    <div class="d-flex flex-column w-100 mb-3"> <!-- Aggiunto mb-3 per margine inferiore -->
                        <label for="bio" class="txtGrey">Bio</label>
                        <textarea name="bio" cols="30" rows="10" class="w-100 p-1">{{ $artist->bio }}</textarea>
                    </div>
                    <div class="d-flex flex-column w-100 mb-3"> <!-- Aggiunto w-100 e mb-3 -->
                        <label for="profile_picture" class="txtGrey">Profile picture</label>
                        <input type="file" name="profile_picture" accept="image/*" class="w-100"> <!-- Aggiunto w-100 -->
                    </div>
                    <button type="submit" class="btn-contrast">update artist</button>
                </form>

                <!-- Form per eliminare l'artista -->
                <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" class="mt-3 w-100"> <!-- Aggiunto w-100 e mt-3 -->
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Are you sure you want to delete this artist?')">
                        delete artist
                    </button>
                </form>
            @else
                <!-- L'artista non esiste ancora, mostra il form per crearlo -->
                <h2>Crea il tuo Artista</h2>
                <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data" class="w-100"> <!-- Aggiunto w-100 -->
                    @csrf
                    <div class="form-group mb-3"> <!-- Aggiunto mb-3 -->
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control w-100" required> <!-- Aggiunto w-100 -->
                    </div>

                    <div class="form-group mb-3"> <!-- Aggiunto mb-3 -->
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" class="form-control w-100" required></textarea> <!-- Aggiunto w-100 -->
                    </div>

                    <div class="form-group mb-3"> <!-- Aggiunto mb-3 -->
                        <label for="profile_picture">Immagine del profilo</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control w-100" <!-- Aggiunto w-100 -->
                            accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Salva Artista</button> <!-- Aggiunto w-100 w-md-auto -->
                </form>
            @endif
        </div>
    </div>
</x-layout>
