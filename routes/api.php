<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/test',function(){
    return response()->json([
        'message'=> 'API berhasil'
    ]);
});
Route::apiResource('products',ProductController::class);
