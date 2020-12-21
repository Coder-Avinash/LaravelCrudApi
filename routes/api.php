<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('products/{id?}',[ProductController::class,'show_product']);
// Route::post('/add',[ProductController::class,'add_product']);
// Route::get('search/{title?}',[ProductController::class,'search_product']);
// Route::delete('delete/{id}',[ProductController::class,'delete_product']);
// Route::put('update/{id}',[ProductController::class,'update_product']);

Route::apiResource("product",ProductController::class);
Route::get('product/search/{title?}',[ProductController::class,'search']);

Route::get('/import_view',[ImportExportController::class,'importview']);
Route::get('/export',[ImportExportController::class,'export_excel'])->name('export');
Route::post('/import',[ImportExportController::class,'import_excel'])->name('import');
Route::get('export_pdf',[ImportExportController::class,'createPDF']);

Route::get('product/filter/{valA?}/{valB?}',[ProductController::class,'filter']);

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::resource('range_filter',ProductController::class);



