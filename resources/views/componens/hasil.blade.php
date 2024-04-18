@extends('page.home')
@section('konten')
    <div class="container">
        <div class="card-container">
            @foreach ($fotos as $photo)
                <a href="{{ route('photo.detail', $photo->id) }}">
                    <div class="card">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="card picture"
                            style="max-height: 150px; max-width: 150px;">
                        <div class="judul-username">
                            <div class="card-bottom">
                                <p>{{ $photo->judulfoto }}</p>
                            </div>
                            <div class="card-username">
                                <img src="{{ asset('storage/' . $photo->image) }}" alt="card picture">
                                <p>{{ $photo->user->username }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
