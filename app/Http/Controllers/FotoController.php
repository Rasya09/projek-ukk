<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\KomentarFoto;
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
        if (auth()->check()) {
            return view('page.tambah_foto');
        } else {
            // Jika pengguna belum login, redirect ke halaman login
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
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
        $komentars = KomentarFoto::where('fotoid', $id)->with('user')->latest()->get();
        return view('componens.detail-foto', compact('photo', 'user', 'komentars'));
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
        return redirect()->route('photo.detail', ['id' => $id])->with('success', 'Foto berhasil diperbarui');
    }


    public function destroy($id)
    {
        $photo = Foto::findOrFail($id);

        // Pastikan pengguna yang sedang login adalah pemilik foto
        if (Auth::id() !== $photo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus foto dari database
        $photo->delete();

        // Redirect ke halaman yang sesuai setelah penghapusan
        return redirect()->route('home')->with('success', 'Foto berhasil dihapus.');
    }


    public function toggleLike($photoId)
    {
        $photo = Foto::findOrFail($photoId);
        $userId = auth()->id();

        if ($photo->likes()->where('userid', $userId)->exists()) {
            // Unlike jika sudah dilike sebelumnya
            $photo->likes()->where('userid', $userId)->delete();
            $message = 'Unlike berhasil';
        } else {
            // Like jika belum dilike sebelumnya
            $photo->likes()->create(['userid' => $userId]);
            $message = 'Like berhasil';
        }

        return redirect()->back()->with('success', $message);
    }

    public function kirimKomentar(Request $request, $id)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mengomentari foto.');
        }

        $request->validate([
            'komentar' => 'required|string',
        ]);

        // Membuat komentar baru
        $komentar = new KomentarFoto();
        $komentar->fotoid = $id;
        $komentar->userid = auth()->id();
        $komentar->isikomentar = $request->komentar;
        $komentar->tanggalkomentar = now();
        $komentar->save();

        return redirect()->back()->with('success', 'Komentar berhasil dikirim');
    }
}

