<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Jika ada query search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%") // Pencarian kolom string lama
                ->orWhere('brand', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('pages.admin.products.product', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.products.product-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric',
            'stok'        => 'nullable|integer',
            'brand'       => 'nullable|string|max:100',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $catName = Category::find($request->category_id)->name ?? null;

        Product::create([
            'nama_produk' => $request->nama_produk,
            'category_id' => $request->category_id,
            'kategori'    => $catName, 
            'stok'        => $request->stok ?? 0,
            'brand'       => $request->brand,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.products.product-edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'brand'       => 'nullable|string',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarPath = $product->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $catName = Category::find($request->category_id)->name ?? null;

        $product->update([
            'nama_produk' => $request->nama_produk,
            'category_id' => $request->category_id,
            'kategori'    => $catName,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'brand'       => $request->brand,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus gambar dari storage
        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return view('pages.admin.products.detail', compact('product'));
    }
}