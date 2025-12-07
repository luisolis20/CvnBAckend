<?php

namespace App\Http\Controllers;

use App\Models\SubareaUnesco;
use Illuminate\Http\Request;

class SubAreaUnescoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = SubareaUnesco::select('sau_id', 'sau_pdid', 'sau_descripcion')->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No se encontraron datos',
                ], 200);
            }

            // Convertir cada item correctamente preservando claves
            $data = $data->map(function ($item) {
                return [
                    'sau_id'         => $item->sau_id,
                    'sau_pdid'       => $item->sau_pdid,
                    'sau_descripcion' => mb_convert_encoding($item->sau_descripcion, 'UTF-8', 'UTF-8')
                ];
            });

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
