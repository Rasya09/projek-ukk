@extends('page.home')
@section('konten')
    <h1>ini tampilan detail</h1>
    <p class="username">{{ $user->username }}</p>
    @if (Auth::id() === $user->id)
        <button class="btn-ikuti">Ikuti</button>
        <a href="{{ route('edit-foto', $photo->id) }}" class="btn-edit">Edit</a>
    @else
        <button class="btn-ikuti">Ikuti</button>
    @endif
    <div class="photo-container">
        <img src="{{ asset('storage/' . $photo->image) }}" alt="Photo">
    </div>
    <h2>{{ $photo->judulfoto }}</h2>
    <div class="profile-container">
        <img src="{{ asset('assets/fotos/profile.png') }}" alt="Profile Picture">
        <span class="username">{{ $user->username }}</span>
    </div>
@endsection
