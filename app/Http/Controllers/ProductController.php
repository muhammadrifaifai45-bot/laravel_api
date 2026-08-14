<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Product::latest()->get(),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stock' => 'required|integer',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes;jpg,jpeg,png,webp|max:2048',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = time() . '.' . $request->file('gambar')->extension();

            $request->file('gambar')->storeAs(
                'products',
                $gambar,
                'public'
            );
        }

        $product = Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stock' => $request->stock,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return response()->json([
            'message' => 'Selamat Data telah berhasil di tambahkan',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stock' => 'required|integer',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }

        $product->nama = $request->nama;
        $product->harga = $request->harga;
        $product->stock = $request->stock;
        $product->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $gambar = time() . '.' . $request->file('gambar')->extension();

            $request->file('gambar')->storeAs(
                'products',
                $gambar,
                'public'
            );

            $product->gambar = $gambar;
        }

        $product->save();

        return response()->json([
            'message' => 'Selamat Data telah berhasil di ubah',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data tidak ada atau tidak di temukan',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'data Berhasil di hapus, selamat dan terimakasih'
        ], 200);
    }
}