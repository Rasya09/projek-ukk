@extends('page.home')
@section('konten')
    @foreach ($fotos as $photo)
        <a href="{{ route('photo.detail', $photo->id) }}">
            <div class="image-container">
                <div class="container-image">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="Photo"
                        style="max-height: 100px; max-width: 100px; margin-top: 40px;">
                </div>
                <h2>{{ $photo->judulfoto }}</h2>
                <div class="profile-container">
                    <img src="{{ asset('assets/fotos/profile.png') }}" alt="Profile Picture">
                    <span class="username">{{ $photo->user->username }}</span>
                </div>
            </div>
        </a>
    @endforeach
@endsection
