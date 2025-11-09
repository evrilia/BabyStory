<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori.
     */
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.category.category', compact('categories'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create()
    {
        return view('pages.admin.category.category-create');
    }

    /**
     * Simpan data kategori baru.
     */
    public function store(Request $request)
    {
        // ✅ Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        // ✅ Simpan ke database
        Category::create($validated);

        // ✅ Redirect kembali dengan pesan sukses
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category->name = $validated['name'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }


    /**
     * (Opsional) Hapus kategori.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    // public function show($slug)
    // {
    //     $categories = Category::all();
    //     $category = Category::where('slug', $slug)->firstOrFail();
    //     $products = $category->products()->paginate(12);

    //     return view('user.category', compact('categories', 'products', 'category'));
    // }

    public function show($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);

        return view('pages.user.category', compact('categories', 'products', 'category'));
    }
}
