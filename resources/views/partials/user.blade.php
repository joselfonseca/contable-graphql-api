@guest
    <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
    @if (Route::has('register'))
        <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
    @endif
@else
    <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span>

    <a href="{{ route('logout') }}"
        class="no-underline hover:underline text-gray-300 text-sm p-3"
        onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        {{ csrf_field() }}
    </form>
@endguest
