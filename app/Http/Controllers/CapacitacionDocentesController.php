<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapacitacionDocente;

class CapacitacionDocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CapacitacionDocente::all();
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
        return CapacitacionDocente::select('capacitacion_docente.*')
        ->where('capacitacion_docente.ciinfper', $id)
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
