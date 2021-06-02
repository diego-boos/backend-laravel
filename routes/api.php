<?php

use App\Http\Controllers\PeliculaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

// mostrar todas los peliculas
Route::get('obtenerPeliculas', [PeliculaController::class,'obtenerPeliculas']);

// mostrar una pelicula específica
Route::get('obtenerPeliculaById/{id}', [PeliculaController::class,'obtenerPeliculaById']);

// agregar nueva pelicula
Route::post('crearPelicula',[PeliculaController::class,'crearPelicula']);

// agregar nueva imagen
Route::post('crearImagen/{id}',[PeliculaController::class,'crearImagen']);

// actualizar pelicula
Route::put('actualizarPelicula/{id}', [PeliculaController::class,'actualizarPelicula']);

// borrar pelicula
Route::delete('eliminarPelicula/{id}', [PeliculaController::class,'eliminarPelicula']);

// buscar película
Route::get('buscarPelicula', [PeliculaController::class,'buscarPelicula']);

//mostrar imagen
Route::get('/uploads/{id}', [PeliculaController::class,'obtenerImagen']);