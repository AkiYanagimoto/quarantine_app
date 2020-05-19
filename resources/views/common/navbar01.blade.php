<nav class="navbar navbar-expand-lg navbar-light">

    <ul class="nav nav-fill">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('REGISTER') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/', $is_production) }}">TOP</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('location', $is_production) }}">STAY HOME</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('profile') }}">PROFILE</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('LOG OUT') }}
                    </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest


    </ul>

</nav>


