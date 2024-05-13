<nav class="text-white">
    <ul class="flex md:flex-col md:items-center md:justify-start w-full">
        <li class="nav-item">
            @auth
                @if(auth()->user()->IsAdmin)
                        <a href="/users" class="nav-link">Users</a>
                @endif
            @endauth
        </li>
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
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link">{{ __('Profile') }}</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
        <li class="nav-item">
            <a href="{{ route('posts.create') }}" class="nav-link">Create</a>
        </li>

        <li class="nav-item">
            <a href="{{ route('posts.index') }}" class="nav-link">Home</a>
        </li>
    </ul>
</nav>
