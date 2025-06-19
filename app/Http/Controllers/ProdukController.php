<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ProdukController extends Controller
{
    public function index() {
        // --- LOGIKA INDEX DIPERBARUI ---
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Admin bisa melihat semua produk, tanpa terkecuali
            $produks = Produk::with('user')->get();
        } else if (Auth::check() && Auth::user()->role == 'penjual') {
            // Penjual hanya melihat produk miliknya sendiri, tanpa terkecuali status
            $produks = Produk::where('user_id', Auth::id())->get();
        } else {
            // Pembeli dan tamu hanya bisa melihat produk yang SUDAH DISETUJUI
            $produks = Produk::where('is_approved', true)->get();
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

        // --- PENYESUAIAN SAAT MEMBUAT PRODUK ---
        Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'user_id' => Auth::user()->id,
            'foto' => $foto,
            'is_approved' => false // Setiap produk baru statusnya menunggu persetujuan
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan dan sedang menunggu persetujuan admin.');
    }

    // ... (fungsi show, edit, update, destroy tidak perlu diubah)
    public function show($id) {
        $produk = Produk::with('reviews.user')->findOrFail($id);
        
        // Tambahan: Cegah pembeli melihat detail produk yang belum disetujui
        if (!($produk->is_approved) && !(Auth::check() && in_array(Auth::user()->role, ['admin', 'penjual']))) {
            abort(404);
        }

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