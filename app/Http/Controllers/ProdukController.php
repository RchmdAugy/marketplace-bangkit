<?php
// File: app/Http/Controllers/ProdukController.php
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
    /**
     * Menampilkan daftar produk, bisa difilter berdasarkan kategori.
     * Menerima $category yang di-inject otomatis oleh Laravel jika route produk.by_category diakses.
     */
    public function index(Category $category = null)
    {
        // Selalu ambil semua kategori untuk ditampilkan sebagai filter
        $categories = Category::orderBy('name')->get(); 
        $currentCategory = $category; // Simpan kategori yang sedang aktif (bisa null)

        // Query dasar untuk produk
        $produkQuery = Produk::with(['user', 'category', 'reviews']); // Eager load relasi

        // Tentukan filter berdasarkan peran pengguna dan kategori yang dipilih
        if (Auth::check() && Auth::user()->role == 'penjual') {
            // Penjual hanya melihat produk miliknya
            $produkQuery->where('user_id', Auth::id());
            // Filter berdasarkan kategori jika ada
            if ($currentCategory) {
                 $produkQuery->where('category_id', $currentCategory->id);
            }
        } else {
             // Pembeli & tamu hanya lihat produk yang approved
            $produkQuery->where('is_approved', true);
             // Filter berdasarkan kategori jika ada
            if ($currentCategory) {
                 $produkQuery->where('category_id', $currentCategory->id);
            }
        }

        // Ambil hasil produk yang sudah difilter
        $produks = $produkQuery->latest()->get();

        // Kirim data ke view
        return view('produk.index', compact('produks', 'categories', 'currentCategory'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create() {
        $categories = Category::orderBy('name')->get();
        return view('produk.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], [
            'nama.required' => 'Nama produk tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi produk tidak boleh kosong.',
            'harga.required' => 'Harga produk tidak boleh kosong.',
            'stok.required' => 'Stok produk tidak boleh kosong.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
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

    /**
     * Menampilkan detail produk.
     */
    public function show($id) {
        $produk = Produk::with(['reviews.user', 'user', 'images', 'category'])->findOrFail($id);
        if (!($produk->is_approved) && !(Auth::check() && in_array(Auth::user()->role, ['admin', 'penjual']))) { abort(404); }
        return view('produk.detail', compact('produk'));
    }

    /**
     * Menampilkan form untuk edit produk.
     */
     public function edit($id) {
        $produk = Produk::with(['images', 'category'])->findOrFail($id);
        if (Auth::id() !== $produk->user_id && Auth::user()->role !== 'admin') { abort(403); }
        $categories = Category::orderBy('name')->get();
        return view('produk.edit', compact('produk', 'categories'));
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, $id) {
         $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
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
            'foto.image' => 'File utama harus berupa gambar.',
            'foto.max' => 'Ukuran file utama maksimal 2MB.',
            'gallery_images.*.image' => 'File galeri harus berupa gambar.',
            'gallery_images.*.mimes' => 'Format gambar galeri tidak valid (hanya jpeg, png, jpg, gif, webp).',
            'gallery_images.*.max' => 'Ukuran setiap gambar galeri maksimal 2MB.',
            'delete_images.*.exists' => 'Gambar galeri yang ingin dihapus tidak valid.'
        ]);

        $produk = Produk::findOrFail($id);
        if (Auth::id() !== $produk->user_id && Auth::user()->role !== 'admin') { abort(403); }

        $dataUpdate = $request->only(['nama', 'deskripsi', 'harga', 'stok', 'category_id']);

        if ($request->hasFile('foto')) {
            if ($produk->foto && File::exists(public_path('foto_produk/'.$produk->foto))) { File::delete(public_path('foto_produk/'.$produk->foto)); }
            $file = $request->file('foto');
            $namaFotoUtama = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('foto_produk'), $namaFotoUtama);
            $dataUpdate['foto'] = $namaFotoUtama;
        }

        $produk->update($dataUpdate);

        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)->where('produk_id', $produk->id)->get();
            foreach ($imagesToDelete as $img) {
                if (File::exists(public_path('foto_produk_gallery/'.$img->image_path))) { File::delete(public_path('foto_produk_gallery/'.$img->image_path)); }
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

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy($id) {
        $produk = Produk::with('images')->findOrFail($id);
        if (Auth::id() !== $produk->user_id && Auth::user()->role !== 'admin') { abort(403); }

        if ($produk->foto && File::exists(public_path('foto_produk/'.$produk->foto))) { File::delete(public_path('foto_produk/'.$produk->foto)); }
        foreach ($produk->images as $img) {
            if (File::exists(public_path('foto_produk_gallery/'.$img->image_path))) {
                File::delete(public_path('foto_produk_gallery/'.$img->image_path));
            }
        }
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}