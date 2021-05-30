<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeliculaController extends Controller
{
    public function obtenerPeliculas()
    {
        return response()->json(Pelicula::all(), 200);
    }

    public function obtenerPeliculaById($id)
    {
        $pelicula = Pelicula::find($id);
        if (is_null($pelicula)) {
            return response()->json(['msg' => 'Película no encontrada'], 404);
        } else {
            return response()->json($pelicula::find($id), 200);
        }
    }

    public function crearPelicula(Request $request)
    {

        $pelicula = new Pelicula();

        if ($request->hasFile('imagen')) {
            $pelicula->imagen = $request->file('imagen')->store('uploads', 'public');
        } else {
            $pelicula->imagen = '';
        }

        $pelicula->nombre = $request->nombre;
        $pelicula->descripcion = $request->descripcion;
        $pelicula->genero = $request->genero;
        $pelicula->duracion = $request->duracion;
        $pelicula->anio = $request->anio;
        $pelicula->save();

        return response($pelicula, 201);
    }

    public function actualizarPelicula(Request $request, $id)
    {
        $pelicula = Pelicula::find($id);
        if (is_null($pelicula)) {
            return response()->json(['msg' => 'Película no encontrada'], 404);
        } else {
            if ($request->hasFile('imagen')) {
                if ($pelicula->imagen != "") {
                    Storage::delete('public/' . $pelicula->imagen);
                    $pelicula->imagen = $request->file('imagen')->store('uploads', 'public');
                } else {
                    $pelicula->imagen = $request->file('imagen')->store('uploads', 'public');
                }
            }
            $pelicula->nombre = $request->nombre;
            $pelicula->descripcion = $request->descripcion;
            $pelicula->genero = $request->genero;
            $pelicula->duracion = $request->duracion;
            $pelicula->anio = $request->anio;
            $pelicula->save();
            return response()->json(['msg' => 'datos actualizados'], 200);
        }
    }

    public function eliminarPelicula($id)
    {
        $pelicula = Pelicula::find($id);
        if (is_null($pelicula)) {
            return response()->json(['msg' => 'Película no encontrada'], 404);
        } else {
            if ($pelicula->imagen == "") {
                $pelicula->delete();
                return response()->json(['msg' => 'Película borrada'], 200);
            }
            if (Storage::delete('public/' . $pelicula->imagen)) {
                $pelicula->delete();
                return response()->json(['msg' => 'Película borrada'], 200);
            }
        }
    }

    public function buscarPelicula(Request $request)
    {
        $pelicula = Pelicula::where('nombre', 'like', $request->nombre."%")->get();
        return response($pelicula, 201);
    }
}
