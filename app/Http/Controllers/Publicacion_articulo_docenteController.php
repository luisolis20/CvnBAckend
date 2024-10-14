<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicacionArticuloDocente;

class Publicacion_articulo_docenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PublicacionArticuloDocente::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PublicacionLibroDocente::select('publicacion_articulo_docente.*')
        ->where('publicacion_articulo_docente.CIInfPer', $id)
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
