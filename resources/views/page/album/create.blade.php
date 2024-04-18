@extends('page.home')
@section('konten')
    <h1>Buat Album Baru</h1>

    <form action="{{ route('store-album') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_album">Nama Album</label>
            <input type="text" name="nama_album" id="nama_album" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Pilih Foto untuk Dimasukkan ke Album</label>
            @foreach ($availablePhotos as $photo)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="foto_ids[]" value="{{ $photo->id }}"
                        id="foto_{{ $photo->id }}">
                    <label class="form-check-label" for="foto_{{ $photo->id }}">
                        {{ $photo->judulfoto }}
                        <br>
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->judulfoto }}"
                            style="max-width: 200px;">
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Simpan Album</button>
    </form>
@endsection
