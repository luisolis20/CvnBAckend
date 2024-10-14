<?php

namespace App\Http\Controllers;
use App\Models\habilidades_informatica;
use Illuminate\Http\Request;

class HabilidadesInformaticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return habilidades_informatica::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'habilidades_informaticas.CIInfPer')
        ->select('habilidades_informaticas.*') 
        ->get();
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
        return habilidades_informatica::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'habilidades_informaticas.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('habilidades_informaticas.*') 
        ->get();
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
