<x-layout :artist="$loggedInArtist ?? null">
    <div class="container h-100 childHeight d-flex flex-column align-items-center justify-content-center w-100">
        <div class=" p-3 col-12 col-md-8 col-lg-6"> 

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($artist)
                <h1 class="fs-3 undergreen">edit your profile</h1>
                <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column align-items-start w-100">
                    @csrf
                    @method('PUT')
                    <div class="w-100 d-flex flex-column mb-3"> 
                        <label for="name" class="txtGrey">name</label>
                        <input type="text" name="name" value="{{ $artist->name }}" required class="w-100 w-md-25 p-1"> 
                    </div>
                    <div class="d-flex flex-column w-100 mb-3"> 
                        <label for="bio" class="txtGrey">bio</label>
                        <textarea name="bio" cols="30" rows="10" class="w-100 p-1">{{ $artist->bio }}</textarea>
                    </div>
                    <div class="d-flex flex-column w-100 mb-3"> 
                        <label for="profile_picture" class="txtGrey">profile picture</label>
                        <input type="file" name="profile_picture" accept="image/*" class="w-100"> 
                    </div>
                    <button type="submit" class="btn-contrast">update artist</button>
                </form>

               
                <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" class="mt-3 mb-3 w-100"> 
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Are you sure you want to delete this artist?')">
                        delete artist
                    </button>
                </form>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                
                    <div id="password-container" style="display: none;">
                        <label for="password">password</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                
                    <button class="btn-delete" type="button" id="delete-account-btn">
                        delete account
                    </button>
                
                    <button class="btn-delete" type="submit" id="confirm-delete-btn" style="display: none;">
                        confirm delete
                    </button>
                </form>
                
                <script>
                    document.getElementById('delete-account-btn').addEventListener('click', function() {
                        document.getElementById('password-container').style.display = 'block';
                        this.style.display = 'none';
                        document.getElementById('confirm-delete-btn').style.display = 'inline-block';
                    });
                </script>
                
                
            @else
               
                <h2 class="fs-3 undergreen">create your artist profile</h2>
                <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data" class="w-100"> 
                    @csrf
                    <div class="form-group mb-3"> 
                        <label for="name" class="txtGrey">name</label>
                        <input type="text" name="name" id="name" class="form-control w-100" required> 
                    </div>

                    <div class="form-group mb-3">
                        <label for="bio" class="txtGrey">bio</label>
                        <textarea name="bio" id="bio" cols="30" rows="10" class="form-control w-100" required></textarea> 
                    </div>

                    <div class="form-group mb-3"> 
                        <label for="profile_picture" class="txtGrey">profile picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control w-100" 
                            accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">save</button> 
                </form>
            @endif
        </div>
    </div>
</x-layout>
