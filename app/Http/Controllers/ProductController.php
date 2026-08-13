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
        return response()->json(Product::latest()->get(),200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama'=>'required',
        'harga' => 'required',
        'stock' => 'required',
        'deskripsi' => 'required',
        'gambar'=>'nullable||image'
      ]);
     $gambar="";
     if($request->hasFile("gambar")){
        $gambar=time(). ".". 
        $request->gambar->extensions();
     }
     
      $product=Product::create([
        'nama'=>$request->nama,
        'harga'=>$request->harga,
        'stock'=>$request->stock,
        'deskripsi'=>$request->deskripsi,
        'gambar'=>''
      ]);
       return response()->json([
            'message'=>'Selamat Data telah berhasil di tambahkan',
            'data'=>$product
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
     $product=Product::find($id);
     if(!$product){
        return response()->json([
            'message'=>'Data Tidak Ditemukan',
            
        ],400);
     }
     return response()->json($product,200);
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

    //menambahkan validasi agar update berhasil dan tidak menampilkan pop up error
    $request->validate([
    'nama'=>'required',
    'harga'=>'required',
    'stock'=>'required',
    'deskripsi'=>'required'
]);
    $product=Product::find($id);
     if(!$product){
        return response()->json([
            'message'=>'Data Tidak Ditemukan',
            
        ],400);
     }

    
    $product->update([
    'nama'=>$request->nama,
    'harga'=>$request->harga,
    'stock'=>$request->stock,
    'deskripsi'=>$request->deskripsi,
    'gambar'=>''
]);
       return response()->json([
            'message'=>'Selamat Data telah berhasil di ubah',
            'data'=>$product
        ]);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id)
    {
        $product=Product::find($id);
     if(!$product){
        return response()->json([
            'message'=>'Data tidak ada atau tidak di temukan',
            
        ],404);
     }
        $product->delete();
        return response()->json([
            'message'=>'data Berhasil di hapus, selamat dan terimakasih'
        ],200);
    }
}
