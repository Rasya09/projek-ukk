<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>bla bla bla</title>
</head>

<body>
    @if (Auth::check())
        <div class="user-logo">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endif
    <a href="{{ route('tambah-foto') }}">tambah</a>
    @yield('konten')
    @yield('scripts')
</body>

</html>
