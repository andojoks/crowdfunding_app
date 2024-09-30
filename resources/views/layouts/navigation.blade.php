<nav class="navbar navbar-default probootstrap-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"
                aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Home</a>
        </div>

        <div id="navbar-collapse" class="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a
                        href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
                <li class="{{ request()->routeIs('causes.index') ? 'active' : '' }}"><a
                        href="{{ route('causes.index') }}">{{ __('Causes') }}</a></li>

                @auth
                    <li class="{{ request()->routeIs('causes.my') ? 'active' : '' }}"><a
                            href="{{ route('causes.my') }}">{{ __('Causes') }}</a></li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a :href="{{ route('profile.edit') }}"> {{ __('Profile') }}</a></li>
                            <li><a :href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}</a></li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @endguest
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</nav>
