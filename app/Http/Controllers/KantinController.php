<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kantinProduk;
use Illuminate\Support\Facades\Storage;

class KantinController extends Controller
{
    public function index()
    {
        $makanan = kantinProduk::where('category', 'makanan')->orderBy('name')->get();
        $minuman = kantinProduk::where('category', 'minuman')->orderBy('name')->get();
        return view('index', compact('makanan', 'minuman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:makanan,minuman',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }

        kantinProduk::create($data);

        return back()->with('status', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $produk = kantinProduk::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:makanan,minuman',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                Storage::disk('public')->delete($produk->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }

        $produk->update($data);

        return back()->with('status', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = kantinProduk::findOrFail($id);
        $nama = $produk->name;

        if ($produk->image && Storage::disk('public')->exists($produk->image)) {
            Storage::disk('public')->delete($produk->image);
        }

        $produk->delete();

        return back()->with('status', "Produk '{$nama}' berhasil dihapus!");
    }

    public function beli($id)
    {
        $produk = kantinProduk::findOrFail($id);

        if ($produk->stock > 0) {
            $produk->decrement('stock');
            return back()->with('status', "Berhasil membeli '{$produk->name}'!");
        }

        return back()->with('status', "Stok '{$produk->name}' sudah habis!");
    }
}
