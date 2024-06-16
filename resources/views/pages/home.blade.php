@guest
    <a href="{{ route('login') }}">Login</a>
@else
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Log Out</button>
    </form>
@endguest
<a href="{{ route('login') }}">Login</a>
@foreach($courses as $course)
    <h2>{{ $course->title  }}</h2>
    <p>{{ $course->description }}</p>
@endforeach
