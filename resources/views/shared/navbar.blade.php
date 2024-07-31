<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ Auth::check() ? route('admin.welcome') : url('/') }}">
            <div class="logo_laravel">
                <img src="{{ Vite::asset('resources/img/logo.png') }}" alt="Logo" style="width: 60px">
            </div>

            {{-- config('app.name', 'Laravel') --}}
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                        <a class="nav-link" href="{{ Auth::check() ? route('admin.welcome') : url('/') }}">{{ __('Home') }}</a>
                    </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.projects.index') }}">{{ __('Projects') }}</a>
                    </li>

                    <!-- Dropdown per le Categorie -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="typeDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Type') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="typeDropdown">
                            @foreach ($types as $type)
                                <a class="dropdown-item"
                                    href="{{ route('admin.projects.index', ['type_id' => $type->id]) }}">
                                    {{ $type->title }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
