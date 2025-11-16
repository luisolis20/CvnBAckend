<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CvnValidacion;

class CvnValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs['fecha_generacion'] = now();
        $res = CvnValidacion::create($inputs);
        return response()->json([
            'data' => $res,
            'mensaje' => "Agregado con Éxito!!",
        ]);

        /*$registro = CvnValidacion::updateOrCreate(
            // 🔍 Condición de búsqueda (solo la cédula)
            ['CIInfPer' => $request->CIInfPer],
            // 🔄 Datos a actualizar o crear
            [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'codigo_unico' => $request->codigo_unico,
                'fecha_generacion' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'mensaje' => $registro->wasRecentlyCreated
                ? 'Registro de validación creado con éxito.'
                : 'Registro de validación actualizado correctamente.',
            'data' => $registro
        ]);*/
    }
    public function verificar(string $codigo)
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
                'fecha_generacion' => $registro->fecha_generacion
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = CvnValidacion::where('CIInfPer', $id)
            ->select('cvn_validaciones.*')
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No se encontraron datos'
            ], 200);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (is_string($value)) {
                    $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $attributes;
        });

        // Retornar la respuesta JSON con los metadatos de paginación
        try {
            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al codificar los datos a JSON: ' . $e->getMessage()], 500);
        }
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
