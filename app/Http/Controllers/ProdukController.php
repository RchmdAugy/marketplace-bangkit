<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ProdukController extends Controller
{
    public function index() {
    if (Auth::check() && Auth::user()->role == 'penjual') {
        // Hanya tampilkan produk milik penjual yang login
        $produks = Produk::where('user_id', Auth::id())->get();
    } else {
        // Untuk admin/pembeli, tampilkan semua produk
        $produks = Produk::all();
    }
    return view('produk.index', compact('produks'));
}

    public function create() {
        return view('produk.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('foto_produk'), $foto);
        }

        Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'user_id' => Auth::user()->id,
            'foto' => $foto
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($id) {
        $produk = Produk::with('reviews.user')->findOrFail($id);
        return view('produk.detail', compact('produk'));
    }

    public function edit($id) {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $produk = Produk::findOrFail($id);

        $foto = $produk->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($foto && file_exists(public_path('foto_produk/'.$foto))) {
                unlink(public_path('foto_produk/'.$foto));
            }
            $file = $request->file('foto');
            $foto = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('foto_produk'), $foto);
        }

        $produk->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $foto
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id) {
        Produk::destroy($id);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
