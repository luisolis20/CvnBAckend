<?php

namespace App\Http\Controllers;

use App\Models\declaracion_personal;
use Illuminate\Http\Request;

class DeclaracionPersonalConsulta extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Consulta base
            $query = declaracion_personal::select(
                'declaracion_personals.id',
                'declaracion_personals.CIInfPer as CIInfPerDE',
                'declaracion_personals.CIInfPer',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'informacionpersonal.fotografia',
            )
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'declaracion_personals.CIInfPer');

            // Verificar si se solicita todos los datos sin paginación
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get();

                // Convertir los datos a UTF-8 válido
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if ($key === 'fotografia' && !empty($value)) {
                            // 🔥 Detectar tipo (opcional)
                            $mime = finfo_buffer(finfo_open(), $value, FILEINFO_MIME_TYPE);
                            if (strpos($mime, 'image') === false) {
                                $mime = 'image/jpeg'; // Valor por defecto
                            }

                            // ✅ Codificar correctamente para el navegador
                            $attributes[$key] = "data:$mime;base64," . base64_encode($value);
                        } elseif (is_string($value) && $key !== 'fotografia') {
                            $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $attributes;
                });

                return response()->json(['data' => $data]);
            }

            // Paginación por defecto
            $data = $query->paginate(20);

            if ($data->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No se encontraron datos'
                ], 200);
            }

            // Convertir los datos de cada página a UTF-8 válido
            $data->getCollection()->transform(function ($item) {
                $attributes = $item->getAttributes();
                foreach ($attributes as $key => $value) {
                    if (is_string($value)) {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $attributes;
            });

            // Retornar respuesta JSON con metadatos de paginación
            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener datos: ' . $e->getMessage()], 500);
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
