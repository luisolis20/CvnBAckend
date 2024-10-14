<?php

namespace App\Http\Controllers;
use App\Models\curso_capacitacion;
use Illuminate\Http\Request;
 
class CursoCapacitaciones extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return curso_capacitacion::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'curso_capacitaciones.CIInfPer')
        ->select('curso_capacitaciones.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        $res = curso_capacitacion::create($inputs);
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
        return curso_capacitacion::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'curso_capacitaciones.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('curso_capacitaciones.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = curso_capacitacion::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->intitucion_curso = $request->intitucion_curso;
            $res->tipo_evento = $request->tipo_evento;
            $res->area_estudios = $request->area_estudios;
            $res->nombre_evento = $request->nombre_evento;
            $res->facilitador_curso = $request->facilitador_curso;
            $res->tipo_certificado = $request->tipo_certificado;
            $res->fecha_inicio_curso = $request->fecha_inicio_curso;
            $res->fecha_fin_curso = $request->fecha_fin_curso;
            $res->dias_curso = $request->dias_curso;
            $res->horas_curso = $request->horas_curso;
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
                'mensaje'=>"Capacitación curso con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = curso_capacitacion::find($id);
        if(isset($res)){
            $elim = curso_capacitacion::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"EL Curso y/o Capacitación no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"EL Curso y/o Capacitación con id: $id no Existe",
            ]);
        }
    }
}
