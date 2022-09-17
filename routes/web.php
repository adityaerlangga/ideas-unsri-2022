<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, "Index"]);
Route::get('/get', [HomeController::class, "getSheet"]);
Route::get('/{organisasi}', [HomeController::class, "Organisasi"]);
Route::get('/competition/{jenis}', [HomeController::class, "Competition"]);
Route::get('command', function () {
    Artisan::call('route:cache');
    Artisan::call('optimize');
    dd("Done");
});
Route::post('/store', [HomeController::class, "Store"]);