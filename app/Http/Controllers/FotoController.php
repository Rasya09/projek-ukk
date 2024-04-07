<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function index()
    {
        $fotos = Foto::with('user')->latest()->get();
        return view('componens.hasil', ['fotos' => $fotos]);
    }

    public function create()
    {
        return view('page.tambah_foto');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'judulfoto' => 'required|string|max:255',
            'deskripsifoto' => 'required|string',
            'image' => 'required|image|max:2048', // File gambar maksimum 2MB
        ]);

        // Simpan gambar yang diunggah
        $imagePath = $request->file('image')->store('photos', 'public');

        // Dapatkan ID pengguna yang sedang masuk
        $userId = Auth::id();

        // Buat record foto baru dalam database
        $photo = new Foto();
        $photo->user_id = $userId; // Set user_id dengan ID pengguna yang sedang masuk
        $photo->judulfoto = $request->judulfoto;
        $photo->deskripsifoto = $request->deskripsifoto;
        $photo->image = $imagePath; // Simpan path gambar ke dalam kolom 'image'
        $photo->tanggalunggah = now(); // Gunakan Carbon untuk mendapatkan tanggal dan waktu saat ini
        $photo->save();

        // Redirect kembali ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('home')->with('success', 'Foto berhasil diunggah');
    }


    public function show($id)
    {
        $photo = Foto::findOrFail($id);
        $user = $photo->user; // Mengambil informasi pengguna yang terkait dengan foto
        return view('componens.detail-foto', compact('photo', 'user'));
    }


    public function edit($id)
    {
        $photo = Foto::findOrFail($id);
        // Pastikan untuk mengambil data foto yang ingin diedit
        return view('componens.edit-foto', ['photo' => $photo]);
    }



    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'judulfoto' => 'required|string|max:255',
            'deskripsifoto' => 'required|string',
            'image' => 'nullable|image|max:2048', // Gambar menjadi opsional untuk diupdate
        ]);

        // Dapatkan ID pengguna yang sedang masuk
        $userId = Auth::id();

        // Cari foto berdasarkan ID
        $photo = Foto::findOrFail($id);

        // Pastikan pengguna memiliki izin untuk mengupdate foto
        if ($photo->user_id != $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupdate foto ini');
        }

        // Periksa apakah ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Simpan gambar yang diunggah
            $imagePath = $request->file('image')->store('photos', 'public');
            // Hapus gambar lama (jika ada)
            Storage::disk('public')->delete($photo->image);
            // Update path gambar di database
            $photo->image = $imagePath;
        }

        // Update judul dan deskripsi foto
        $photo->judulfoto = $request->judulfoto;
        $photo->deskripsifoto = $request->deskripsifoto;

        // Simpan perubahan
        $photo->save();

        // Redirect kembali ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('home', ['id' => $id])->with('success', 'Foto berhasil diperbarui');
    }


    public function destroy(Foto $foto)
    {
        $foto->delete();

        return redirect()->route('fotos.index')
            ->with('success', 'Foto deleted successfully');
    }
}
