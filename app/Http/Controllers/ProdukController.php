<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index(Category $category = null)
    {
        $categories = Category::orderBy('name')->get();
        $currentCategory = $category;
        $produkQuery = Produk::with(['user', 'category', 'reviews']);

        if (Auth::check() && Auth::user()->role == 'penjual') {
            $produkQuery->where('user_id', Auth::id());
            if ($currentCategory) {
                $produkQuery->where('category_id', $currentCategory->id);
            }
        } else {
            $produkQuery->where('is_approved', true);
            if ($currentCategory) {
                $produkQuery->where('category_id', $currentCategory->id);
            }
        }
        $produks = $produkQuery->latest()->get();
        return view('produk.index', compact('produks', 'categories', 'currentCategory'));
    }

    public function create() {
        $categories = Category::orderBy('name')->get();
        return view('produk.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'nama_umkm' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], [
            'nama.required' => 'Nama produk tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi produk tidak boleh kosong.',
            'harga.required' => 'Harga produk tidak boleh kosong.',
            'stok.required' => 'Stok produk tidak boleh kosong.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'nama_umkm.required' => 'Nama UMKM/Pembuat produk tidak boleh kosong.',
            'foto.image' => 'File utama harus berupa gambar.',
            'foto.max' => 'Ukuran file utama maksimal 2MB.',
            'gallery_images.*.image' => 'File galeri harus berupa gambar.',
            'gallery_images.*.mimes' => 'Format gambar galeri tidak valid (hanya jpeg, png, jpg, gif, webp).',
            'gallery_images.*.max' => 'Ukuran setiap gambar galeri maksimal 2MB.',
        ]);

        $namaFotoUtama = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFotoUtama = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('foto_produk'), $namaFotoUtama);
        }

        $produk = Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'user_id' => Auth::id(),
            'foto' => $namaFotoUtama,
            'category_id' => $request->category_id,
            'nama_umkm' => $request->nama_umkm,
            'is_approved' => false
        ]);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryFile) {
                $namaFotoGaleri = time() . '_' . uniqid() . '_' . $galleryFile->getClientOriginalName();
                $galleryFile->move(public_path('foto_produk_gallery'), $namaFotoGaleri);
                $produk->images()->create(['image_path' => $namaFotoGaleri]);
            }
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function show($id) {
        $produk = Produk::with(['reviews.user', 'user', 'images', 'category'])->findOrFail($id);
        if (!($produk->is_approved) && !(Auth::check() && in_array(Auth::user()->role, ['admin', 'penjual']))) {
            abort(404);
        }
        return view('produk.detail', compact('produk'));
    }

     public function edit($id) {
        $produk = Produk::with(['images', 'category'])->findOrFail($id);
        if (Auth::id() !== $produk->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }
        $categories = Category::orderBy('name')->get();
        return view('produk.edit', compact('produk', 'categories'));
    }

    public function update(Request $request, $id) {
         $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'nama_umkm' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id'
         ], [
            'nama.required' => 'Nama produk tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi produk tidak boleh kosong.',
            'harga.required' => 'Harga produk tidak boleh kosong.',
            'stok.required' => 'Stok produk tidak boleh kosong.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'nama_umkm.required' => 'Nama UMKM/Pembuat produk tidak boleh kosong.',
            'foto.image' => 'File utama harus berupa gambar.',
            'foto.max' => 'Ukuran file utama maksimal 2MB.',
            'gallery_images.*.image' => 'File galeri harus berupa gambar.',
            'gallery_images.*.mimes' => 'Format gambar galeri tidak valid (hanya jpeg, png, jpg, gif, webp).',
            'gallery_images.*.max' => 'Ukuran setiap gambar galeri maksimal 2MB.',
            'delete_images.*.exists' => 'Gambar galeri yang ingin dihapus tidak valid.'
        ]);

        $produk = Produk::findOrFail($id);
        if (Auth::id() !== $produk->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $dataUpdate = $request->only(['nama', 'deskripsi', 'harga', 'stok', 'category_id', 'nama_umkm']);

        if ($request->hasFile('foto')) {
            if ($produk->foto && File::exists(public_path('foto_produk/'.$produk->foto))) {
                File::delete(public_path('foto_produk/'.$produk->foto));
            }
            $file = $request->file('foto');
            $namaFotoUtama = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('foto_produk'), $namaFotoUtama);
            $dataUpdate['foto'] = $namaFotoUtama;
        }

        if(Auth::user()->role !== 'admin'){
            $dataUpdate['is_approved'] = false;
        }

        $produk->update($dataUpdate);

        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)->where('produk_id', $produk->id)->get();
            foreach ($imagesToDelete as $img) {
                if (File::exists(public_path('foto_produk_gallery/'.$img->image_path))) {
                    File::delete(public_path('foto_produk_gallery/'.$img->image_path));
                }
                $img->delete();
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryFile) {
                $namaFotoGaleri = time() . '_' . uniqid() . '_' . $galleryFile->getClientOriginalName();
                $galleryFile->move(public_path('foto_produk_gallery'), $namaFotoGaleri);
                $produk->images()->create(['image_path' => $namaFotoGaleri]);
            }
        }

        $message = 'Produk berhasil diperbarui.';
        if(Auth::user()->role !== 'admin' && !$produk->is_approved) {
             $message .= ' Produk menunggu persetujuan ulang.';
        }
        return redirect()->route('produk.index')->with('success', $message);
     }

    public function destroy($id) {
        $produk = Produk::with('images')->findOrFail($id);
        if (Auth::id() !== $produk->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($produk->foto && File::exists(public_path('foto_produk/'.$produk->foto))) {
            File::delete(public_path('foto_produk/'.$produk->foto));
        }
        foreach ($produk->images as $img) {
            if (File::exists(public_path('foto_produk_gallery/'.$img->image_path))) {
                File::delete(public_path('foto_produk_gallery/'.$img->image_path));
            }
        }
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}