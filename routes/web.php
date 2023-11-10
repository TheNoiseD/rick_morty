<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Controller::class,'index'])->name('welcome');
Route::post('/saveCharacter', [Controller::class,'saveCharacter'])->name('saveCharacter');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/characters', [Controller::class,'characters'])->name('characters');
    Route::get('/my-characters', [Controller::class,'myCharacters'])->name('my.characters');
    Route::delete('/delete-character/{id}', [Controller::class,'deleteCharacter'])->name('delete.character');

});
