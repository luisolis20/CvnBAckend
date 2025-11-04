<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CvnValidacion;

class CvnValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $registro = CvnValidacion::create([
            'CIInfPer' => $request->CIInfPer,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'codigo_unico' => $request->codigo_unico,
            'fecha_generacion' => now()
        ]);

        return response()->json(['success' => true, 'data' => $registro]);
    }
    public function verificar($codigo)
    {
        $registro = CvnValidacion::where('codigo_unico', $codigo)->first();

        if (!$registro) {
            return response()->json(['valido' => false, 'mensaje' => 'Código no encontrado.']);
        }

        return response()->json([
            'valido' => true,
            'data' => [
                'CIInfPer' => $registro->CIInfPer,
                'nombres' => $registro->nombres,
                'apellidos' => $registro->apellidos,
                'fecha_generacion' => $registro->fecha_generacion->format('d/m/Y H:i:s')
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
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
