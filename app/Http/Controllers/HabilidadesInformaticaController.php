<?php

namespace App\Http\Controllers;
use App\Models\habilidades_informatica;
use Illuminate\Http\Request;

class HabilidadesInformaticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = habilidades_informatica::select('habilidades_informaticas.*') 
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'habilidades_informaticas.CIInfPer');
            // Verificar si se solicita todos los datos sin paginación
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get();
    
                // Convertir los datos a UTF-8 válido
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if (is_string($value)) {
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
                return response()->json(['error' => 'No se encontraron datos'], 404);
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
            return response()->json(['error' => 'Error al codificar los datos a JSON: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        
        
        $res = habilidades_informatica::create($inputs);
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
        $data = habilidades_informatica::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'habilidades_informaticas.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('habilidades_informaticas.*') 
        ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
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
        $res = habilidades_informatica::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->habilidades_comunicativas = $request->habilidades_comunicativas;
            $res->descripcion_habilidades_comunicativas = $request->descripcion_habilidades_comunicativas;
            $res->habilidades_creativas = $request->habilidades_creativas;
            $res->descripcion_habilidades_creativas = $request->descripcion_habilidades_creativas;
            $res->habilidades_liderazgo = $request->habilidades_liderazgo;
            $res->descripcion_habilidades_liderazgo = $request->descripcion_habilidades_liderazgo;
            $res->habilidades_informaticas_cv = $request->habilidades_informaticas_cv;
            $res->descripcion_habilidades_informaticas_cv = $request->descripcion_habilidades_informaticas_cv;
            $res->oficios_subactividades = $request->oficios_subactividades;
            $res->descripcion_oficios_subactividades = $request->descripcion_oficios_subactividades;
            $res->otro_habilidades = $request->otro_habilidades;
           
            if($res->save()){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Actualizado con Éxito!!",
                ]);
            }
            else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>"Error al Actualizar",
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"Habilidad con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = habilidades_informatica::find($id);
        if(isset($res)){
            $elim = habilidades_informatica::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Habilidad no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Habilidad con id: $id no Existe",
            ]);
        }
    }
}
