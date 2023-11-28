<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("/posts", function (Request $request) {
    return response()->json([
        "title" => "My first post",
        "body" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Sed euismod, nisl eget ultricies ultrices, nunc nisl aliquam nunc, vitae aliquam nisl
        nunc vitae nisl. Sed euismod, nisl eget ultricies ultrices, nunc nisl aliquam nunc, vitae aliquam nisl nunc vitae nisl.",
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
