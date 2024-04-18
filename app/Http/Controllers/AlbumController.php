<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;


class AlbumController extends Controller
{
    /**
     * Menampilkan daftar semua album pengguna.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::where('user_id', auth()->id())->get();
        return view('album.index', compact('albums'));
    }

    /**
     * Menampilkan formulir untuk membuat album baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ambil daftar foto yang tersedia untuk dipilih
        $availablePhotos = Foto::where('user_id', auth()->id())->whereNull('album_id')->get();

        return view('page.album.create', compact('availablePhotos'));
    }

    /**
     * Menyimpan album baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama_album' => 'required|string|max:255',
            'foto_ids' => 'required|array|min:1',
        ]);

        // Buat album baru
        $album = Album::create([
            'namaAlbum' => $request->nama_album,
            'user_id' => auth()->id(),
            'tanggaldibuat' => now(), // Tanggal pembuatan album
        ]);

        // Ambil ID album yang baru dibuat
        $albumId = $album->id;

        // Ambil ID foto-foto yang dipilih
        $selectedPhotoIds = $request->input('foto_ids');

        // Update kolom album_id pada foto-foto yang dipilih
        Foto::whereIn('id', $selectedPhotoIds)->update(['album_id' => $albumId]);

        return redirect()->route('user.profile', auth()->id())->with('success', 'Album berhasil dibuat.');
    }


    /**
     * Menampilkan detail album.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::findOrFail($id);
        // Pastikan hanya pengguna yang memiliki album tersebut yang dapat melihatnya
        if ($album->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('album.show', compact('album'));
    }

    /**
     * Menampilkan formulir untuk mengedit album.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::findOrFail($id);
        // Pastikan hanya pengguna yang memiliki album tersebut yang dapat mengeditnya
        if ($album->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('album.edit', compact('album'));
    }

    /**
     * Memperbarui album yang ada dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_album' => 'required|string|max:255',
        ]);

        $album = Album::findOrFail($id);
        // Pastikan hanya pengguna yang memiliki album tersebut yang dapat mengeditnya
        if ($album->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $album->namaAlbum = $validatedData['nama_album'];
        $album->save();

        return redirect()->route('albums.index')
            ->with('success', 'Album berhasil diperbarui.');
    }

    /**
     * Menghapus album dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        // Pastikan hanya pengguna yang memiliki album tersebut yang dapat menghapusnya
        if ($album->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $album->delete();

        return redirect()->route('albums.index')
            ->with('success', 'Album berhasil dihapus.');
    }
}
