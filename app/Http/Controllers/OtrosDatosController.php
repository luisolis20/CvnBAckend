<?php

namespace App\Http\Controllers;
use App\Models\otros_datos_relevante;
use Illuminate\Http\Request;

class OtrosDatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return otros_datos_relevante::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'otros_datos_relevantes.CIInfPer')
        ->select('otros_datos_relevantes.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
       
        
        
        $res = otros_datos_relevante::create($inputs);
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
        return otros_datos_relevante::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'otros_datos_relevantes.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('otros_datos_relevantes.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = otros_datos_relevante::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->tipo_logros = $request->tipo_logros;
            $res->descripcion_logros = $request->descripcion_logros;
            $res->descripcion_fracasos = $request->descripcion_fracasos;
            
           
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
                'mensaje'=>"Relevante con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $res = otros_datos_relevante::find($id);
        if(isset($res)){
            $elim = otros_datos_relevante::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"El Logro no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El Logro con id: $id no Existe",
            ]);
        }
    }
}
