<?php
use App\Http\Controllers\ProgramDonasiController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function () {
    return view('welcome');
});

Route::get('/adminDashboard', function () {
    return view('adminDashboard');
});

Route::get('/daftarevent', function () {
    return view('daftarevent');
});

Route::get('/daftartestimoni', function () {
    return view('daftartestimoni');
});
// Route::Resource('/daftarevent', ProgramDonasiController::class);
// Route::get('/daftarhapus/{id_program}', [ProgramDonasiController::class,'destroy']);

