@extends('page.home')

@section('konten')
    <div class="konten">
        <i class="fa-solid fa-arrow-left"></i>
        <div class="container-unggah-content">
            <div class="judul-container-unggah">
                <p>Unggah Gambar</p>
            </div>
            <form action="{{ route('kirim-foto') }}" method="post" enctype="multipart/form-data" style="width: 100%">
                @csrf
                {{-- <div class="kotak" onclick="pilihFile()">
                    <i id="uploadIcon" class="fa-solid fa-upload"></i>
                    <p id="fileName">Unggah foto disini</p>
                    <input type="file" id="image" name="image" onchange="tampilkanGambar()" />
                </div> --}}
                <input type="file" name="image" id="image">
                <div id="gambarContainer" style="display: none;" class="container-gambar-diupload">
                    <img id="previewGambar" src="" alt="Preview Gambar" style="max-width: 100%; max-height: 200px;">
                </div>
                <div class="form-unggah">
                    <div class="form-group">
                        <label for="judulfoto">Judul</label>
                        <input type="text" name="judulfoto" id="judulfoto" placeholder="Masukkan Judul Disini">
                    </div>
                    <div class="form-group">
                        <label for="deskripsifoto">Deskripsi</label>
                        <textarea name="deskripsifoto" id="deskripsifoto" placeholder="Masukkan Deskripsi"></textarea>
                    </div>
                    <button type="submit" class="btn-save">Unggah Foto</button>
                </div>
            </form>

        </div>
    </div>
@endsection
