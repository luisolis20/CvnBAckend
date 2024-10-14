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
        return Experiencia_Profesional_D::join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'experiencia_profesional_docentes.CIInfPer')
        ->select('experiencia_profesional_docentes.*') 
        ->get();
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
        return Experiencia_Profesional_D::join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'experiencia_profesional_docentes.CIInfPer')
        ->where('informacionpersonal_d.CIInfPer', $id)
        ->select('experiencia_profesional_docentes.*') 
        ->get();
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
