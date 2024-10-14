<?php

namespace App\Http\Controllers;
use App\Models\FichaSocioeconomica;

use Illuminate\Http\Request;

class FichaSocioEconomicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FichaSocioeconomica::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return FichaSocioeconomica::select('fichasocioeconomica.*')
        ->where('fichasocioeconomica.CIInfPer', $id)
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
