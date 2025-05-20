<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index() {
        $items = Keranjang::where('user_id', Auth::id())->with('produk')->get();
        return view('keranjang.index', compact('items'));
    }

    public function add(Request $request, $produk_id) {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $keranjang = Keranjang::updateOrCreate(
            ['user_id' => Auth::id(), 'produk_id' => $produk_id],
            ['jumlah' => \DB::raw('jumlah + '.$request->jumlah)]
        );
        return redirect()->route('keranjang.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function remove($id) {
        Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function update(Request $request, $id) {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $keranjang = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();
        return redirect()->route('keranjang.index')->with('success', 'Jumlah produk berhasil diupdate!');
    }
}