<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionPersonald;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InformacionPersonal_DController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InformacionPersonald::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        $inputs["ClaveUsu"] = md5(trim($request->ClaveUsu)); 
        $res = InformacionPersonald::create($inputs);
        return response()->json([
            'data'=>$res,
            'mensaje'=>"Agregado con Éxito!!",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       // Aplica paginación al resultado del filtro
        $data = InformacionPersonald::select('informacionpersonal_d.*')
            ->where('informacionpersonal_d.CIInfPer', $id)
            ->paginate(20);
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();

            foreach ($attributes as $key => $value) {
                if (in_array($key, ['fotografia']) && !empty($value)) {
                    // ✅ Convertir BLOB a base64
                    $attributes[$key] = base64_encode($value);
                } elseif (is_string($value) && !in_array($key, ['fotografia'])) {
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
         $res = InformacionPersonald::find($id);

        if (!isset($res)) {
            return response()->json([
                'error' => true,
                'mensaje' => "El registro con id: $id no Existe",
            ]);
        }

        $updateData = [];

        // --- SOLUCIÓN FINAL Y DEFINITIVA PARA BLOB (Usando DB::raw) ---
        if (!empty($request->fotografia)) {
            // 1. Decodificar la cadena Base64 a datos binarios puros.
            $binaryData = base64_decode($request->fotografia);

            // 2. Envolver los datos binarios en DB::raw(). Esto le dice a PDO que NO
            // trate el valor como una cadena UTF-8, sino como el binario que es.
            $updateData['fotografia'] = DB::raw("FROM_BASE64('" . base64_encode($binaryData) . "')");

            // Nota: Este truco requiere que MySQL decodifique, pero en el backend de Laravel
            // solo necesitamos el DB::raw. Si estás usando SQLite o PostgreSQL, el enfoque cambia.
            // Para MySQL, esta es la forma más limpia de forzar el binario sin errores de PHP.
            // Una forma más universal para Laravel/MySQL es:

            // $updateData['fotografia'] = $binaryData; // Asignamos el binario decodificado.

            // Y luego usamos un update directo sobre el Query Builder para aplicar el binario.
            // Si solo actualizas la foto, usa la siguiente lógica:
            try {
                // Usamos el Query Builder para asegurarnos de que el binario se maneje correctamente.
                // Es crucial para datos BLOB.
                DB::table('informacionpersonal_d')
                    ->where('CIInfPer', $id)
                    ->update(['fotografia' => $binaryData]);

                // Recargar el modelo para que la respuesta JSON incluya la foto actualizada
                $res = InformacionPersonald::find($id);

                $data = $res->toArray();

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Actualizado con Éxito!!",
                ]);
            } catch (\Exception $e) {
                // Si falla por cualquier razón (ej. timeout, db error), capturamos aquí
                return response()->json([
                    'error' => true,
                    'mensaje' => "Error al Actualizar la foto: " . $e->getMessage(),
                ], 500);
            }
        }

        // Si no hay foto en el request, asumimos que no hay nada que actualizar.
        // Si tienes otros campos que actualizar, esta lógica DEBE ser más compleja.

        return response()->json([
            'error' => true,
            'mensaje' => "No se proporcionó la fotografía para actualizar.",
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
