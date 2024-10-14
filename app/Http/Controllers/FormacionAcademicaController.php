<?php

namespace App\Http\Controllers;
use App\Models\formacion_academica;
use Illuminate\Http\Request;

class FormacionAcademicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return formacion_academica::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'formacion_academicas.CIInfPer')
        ->select('formacion_academicas.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        
        $res = formacion_academica::create($inputs);
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
        return formacion_academica::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'formacion_academicas.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('formacion_academicas.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = formacion_academica::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->estudios_bachiller_culminados = $request->estudios_bachiller_culminados;
            $res->titulo_bachiller_obtenido = $request->titulo_bachiller_obtenido;
            $res->institucion_bachiller = $request->institucion_bachiller;
            $res->fecha_graduacion_bachiller = $request->fecha_graduacion_bachiller;
            $res->especialidad_bachiller = $request->especialidad_bachiller;

            $res->estudios_universitarios_culminados = $request->estudios_universitarios_culminados;
            $res->titulo_universitario_obtenido = $request->titulo_universitario_obtenido;
            $res->institucion_universitaria = $request->institucion_universitaria;
            $res->fecha_graduacion = $request->fecha_graduacion;
            $res->especialidad = $request->especialidad;
           
            $res->estudios_posgrado_culminados = $request->estudios_posgrado_culminados;
            $res->titulo_posgrado_obtenido = $request->titulo_posgrado_obtenido;
            $res->institucion_posgrado = $request->institucion_posgrado;
            $res->fecha_graduacion_posgrado = $request->fecha_graduacion_posgrado;
            $res->especialidad_posgrado = $request->especialidad_posgrado;
            
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
                'mensaje'=>"formacion Academica con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = formacion_academica::find($id);
        if(isset($res)){
            $elim = formacion_academica::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Formacion Academica no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Formacion Academica con id: $id no Existe",
            ]);
        }
    }
}
