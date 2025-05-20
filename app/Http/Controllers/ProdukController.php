<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ProdukController extends Controller
{
    public function index() {
        $produks = Produk::all();
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
        ]);

        Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($id) {
        $produk = Produk::findOrFail($id);
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
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id) {
        Produk::destroy($id);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
