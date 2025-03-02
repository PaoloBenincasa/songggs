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
            <div class="container">
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

    <section class="d-flex justify-content-center">
        <div class="w-25">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet accusamus quo sapiente facere nisi! Possimus
            fugiat commodi molestiae officiis aspernatur facilis autem ab esse. Libero nihil eaque suscipit eum dolorum
            voluptas blanditiis aliquid odit quibusdam nostrum odio ad nobis nesciunt quos aut inventore vero fuga
            minima, voluptatem nisi quia? Harum incidunt saepe dolore quod sequi maxime voluptates iusto? Dolore quo
            molestias vitae repudiandae ea voluptatum at nesciunt? Molestias cupiditate ipsa officiis a provident
            tenetur autem exercitationem sint impedit quos delectus, veniam aperiam quo debitis quibusdam voluptates
            labore incidunt et. Libero, hic cupiditate? Deleniti velit officia praesentium, repellendus maiores
            assumenda ipsum molestiae cumque accusantium facere, saepe iure excepturi quis ducimus consectetur iusto eos
            nesciunt omnis optio! Accusantium illo quod, dignissimos voluptatum temporibus incidunt amet aliquam quae
            maxime quo doloremque optio quidem totam ut pariatur nostrum obcaecati consequuntur similique qui. Maxime
            tenetur dolor eligendi laborum nihil quae, excepturi quos aliquid ratione repudiandae libero, unde facere
            corrupti! Ab exercitationem quod nihil ullam molestiae commodi eos error libero? Consequuntur voluptatem
            tempora, nobis, ipsam voluptatibus iusto nemo magnam quos reiciendis dolores explicabo odio ipsa quasi unde
            eos quidem recusandae. Asperiores cumque assumenda nisi repellendus nemo consequatur molestiae dolor ipsam
            quasi ducimus! Sint, illo. Quasi, cum.
        </div>
    </section>

</x-layout>
