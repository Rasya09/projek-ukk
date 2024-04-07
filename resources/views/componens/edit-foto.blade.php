@extends('page.home')

@section('konten')
    <div class="konten">
        <i class="fa-solid fa-arrow-left"></i>
        <div class="container-unggah-content">
            <div class="judul-container-unggah">
                <p>Edit Gambar</p>
            </div>
            <form action="{{ route('update-foto', $photo->id) }}" method="post" enctype="multipart/form-data"
                style="width: 100%">
                @csrf
                @method('PUT')
                <div class="kotak" onclick="pilihFile()">
                    <i id="uploadIcon" class="fa-solid fa-upload"></i>
                    <p id="fileName">Unggah foto disini</p>
                    <input type="file" id="image" name="image" style="display: none;"
                        onchange="tampilkanGambar()" />
                </div>
                <div id="gambarContainer" style="display: none;" class="container-gambar-diupload">
                    <img id="previewGambar" src="{{ asset('storage/' . $photo->image) }}" alt="Preview Gambar"
                        style="max-width: 100%; max-height: 200px;">
                </div>
                <img id="gambarSebelumnya" class="gambar-sebelumnya" src="{{ asset('storage/' . $photo->image) }}"
                    alt="Gambar sedang bermasalah" style="margin: 10px 0; max-width: 100%; max-height: 200px;">
                <div class="form-unggah">
                    <div class="form-group">
                        <label for="judulfoto">Judul</label>
                        <input type="text" name="judulfoto" id="judulfoto" value="{{ $photo->judulfoto }}"
                            placeholder="Masukkan Judul Disini">
                    </div>
                    <div class="form-group">
                        <label for="deskripsifoto">Deskripsi</label>
                        <textarea name="deskripsifoto" id="deskripsifoto" placeholder="Masukkan Deskripsi">{{ $photo->deskripsifoto }}</textarea>
                    </div>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function pilihFile() {
            document.getElementById('image').click();
        }

        function tampilkanGambar() {
            var input = document.getElementById('image');
            var fileName = document.getElementById('fileName');
            var uploadIcon = document.getElementById('uploadIcon');
            var gambarContainer = document.getElementById('gambarContainer');
            var previewGambar = document.getElementById('previewGambar');
            var gambarSebelumnya = document.getElementById('gambarSebelumnya');

            if (input.files.length > 0) {
                var file = input.files[0];

                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewGambar.src = e.target.result;
                        gambarContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);

                    fileName.textContent = file.name;
                    uploadIcon.className = 'fa-solid fa-download';
                    // Sembunyikan gambar sebelumnya
                    gambarSebelumnya.style.display = 'none';
                } else {
                    alert("Silahkan pilih file gambar.");
                    input.value = '';
                }
            } else {
                fileName.textContent = "Silahkan pilih foto";
                uploadIcon.className = 'fa-solid fa-upload';
                gambarContainer.style.display = 'none';
            }
        }
    </script>
@endsection
