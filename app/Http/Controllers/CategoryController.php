<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori (Admin)
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('pages.admin.category.category', compact('categories'));
    }

    /**
     * Tampilkan form tambah kategori (Admin)
     */
    public function create()
    {
        return view('pages.admin.category.category-create');
    }

    /**
     * Simpan data kategori baru (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5102',
        ]);

        // 2. Handle upload gambar
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        // 3. Simpan
        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit kategori (Admin) - INI YANG HILANG TADI
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.admin.category.edit', compact('category'));
    }

    /**
     * Update data kategori (Admin)
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5102',
        ]);

        // Update data teks
        $category->name = $validated['name'];
        $category->description = $validated['description'] ?? null;

        // Update gambar jika ada upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori (Admin)
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Tampilkan halaman kategori untuk User (Frontend)
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all();
        $products = Product::where('category_id', $id)->paginate(12);

        return view('pages.user.category', compact('category', 'categories', 'products'));
    }
}