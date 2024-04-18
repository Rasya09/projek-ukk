@extends('page.home')
@section('konten')
    <h1>ini tampilan detail</h1>
    <p class="username">{{ $user->username }}</p>
    @if (Auth::id() === $photo->user_id)
        <a href="{{ route('edit-foto', $photo->id) }}" class="btn-edit">Edit</a>
        <form action="{{ route('hapus-foto', $photo->id) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">Hapus</button>
        </form>
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
    <div class="like-section">
        @auth
            <form action="{{ route('photo.like', ['id' => $photo->id]) }}" method="post">
                @csrf
                <button type="submit" class="like-button {{ $photo->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                    <i class="fa-solid fa-heart"></i> Like
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="like-button">
                <i class="fa-solid fa-heart"></i> Like
            </a>
        @endauth
        <span class="like-count">{{ $photo->likes()->count() }} likes</span>
    </div>
    <form action="{{ route('kirim-komentar', ['id' => $photo->id]) }}" method="post">
        @csrf
        <textarea name="komentar" id="komentar" cols="30" rows="3" placeholder="Tulis komentar Anda"></textarea>
        <button type="submit">Kirim</button>
    </form>
    @foreach ($komentars as $komentar)
        <div class="komentar" style="display: flex;">
            <p style="margin-right: 30px ">ini usernamme : {{ $komentar->user->username }}</p>
            <p>ini Komentarnya : {{ $komentar->isikomentar }}</p>
            <span class="comment-date">
                @php
                    // Ambil tanggal komentar
                    $commentDate = $komentar->created_at;
                    // Ambil tanggal saat ini
                    $now = now();

                    // Hitung selisih hari antara tanggal komentar dan tanggal saat ini
                    $daysDifference = $now->diffInDays($commentDate);

                    // Tentukan teks yang akan ditampilkan sesuai dengan selisih hari
                    if ($daysDifference == 0) {
                        echo 'Hari ini';
                    } elseif ($daysDifference == 1) {
                        echo 'Kemarin';
                    } elseif ($daysDifference >= 7) {
                        echo $daysDifference . ' hari yang lalu';
                    } else {
                        // Jika lebih dari seminggu, tampilkan tanggal biasa
                        echo $commentDate->format('d F Y');
                    }
                @endphp
            </span>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script>
        function toggleLike(photoId) {
            var likeButton = document.getElementById('likeButton' + photoId);

            // Ubah warna ikon saat tombol like diklik
            if (likeButton.classList.contains('text-red-500')) {
                likeButton.classList.remove('text-red-500');
            } else {
                likeButton.classList.add('text-red-500');
            }

            // Kirim permintaan AJAX untuk toggle like
            fetch(`/photo/${photoId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
