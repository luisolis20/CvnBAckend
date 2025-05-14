<?php

namespace App\Http\Controllers;
use App\Models\Experiencia_Profesional_D;
use Illuminate\Http\Request;

class Experiencia_ProfesionalDocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Experiencia_Profesional_D::join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'experiencia_profesional_docentes.CIInfPer')
        ->select('experiencia_profesional_docentes.*') 
        ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos'], 404);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        $res = Experiencia_Profesional_D::create($inputs);
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
        $data =  Experiencia_Profesional_D::join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'experiencia_profesional_docentes.CIInfPer')
        ->where('informacionpersonal_d.CIInfPer', $id)
        ->select('experiencia_profesional_docentes.*') 
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
        $res = Experiencia_Profesional_D::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->cargos_desempenados = $request->cargos_desempenados;
            $res->empresa_institucion = $request->empresa_institucion;
            $res->fecha_inicio_empresa = $request->fecha_inicio_empresa;
            $res->fecha_fin_empresa = $request->fecha_fin_empresa;
            $res->cargo_desempenado_empresa = $request->cargo_desempenado_empresa;
            $res->descripcion_funciones_empresa = $request->descripcion_funciones_empresa;
            $res->logros_resultados_empresa = $request->logros_resultados_empresa;

            $res->practicas_profesionales = $request->practicas_profesionales;
            $res->empresa_institucion_practicas = $request->empresa_institucion_practicas;
            $res->fecha_inicio_practicas = $request->fecha_inicio_practicas;
            $res->fecha_fin_practicas = $request->fecha_fin_practicas;
            $res->area_trabajo_practicas = $request->area_trabajo_practicas;
            $res->descripcion_funciones_practicas = $request->descripcion_funciones_practicas;
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
                'mensaje'=>"Experiencia con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Experiencia_Profesional_D::find($id);
        if(isset($res)){
            $elim = Experiencia_Profesional_D::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Experiencia Profesional no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Experiencia Profesional con id: $id no Existe",
            ]);
        }
    }
}
