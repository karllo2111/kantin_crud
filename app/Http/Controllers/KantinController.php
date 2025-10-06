<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kantinProduk;

class KantinController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $sort = $request->get('sort', 'desc');

        $query = kantinProduk::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($sort == 'asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort == 'desc') {
            $query->orderBy('created_at', 'desc');
        }

        $kantinProduk = $query->get();
        $totalProducts = $kantinProduk->count();

        return view('index', compact('kantinProduk', 'totalProducts', 'category', 'sort'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'category' => 'required|in:makanan,minuman',
        ]);

        kantinProduk::create($request->all());
        return redirect()->route('index')->with('status', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kantinProduk = kantinProduk::findOrFail($id);
        $kantinProduk->update($request->all());

        return redirect()->route('index')->with('status', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
{
    $kantinProduk = kantinProduk::findOrFail($id);
    $namaProduk = $kantinProduk->name; // ambil nama produk dulu
    $kantinProduk->delete();

    return redirect()->route('index')
        ->with('status', "Produk '{$namaProduk}' berhasil dihapus!");
}

}
