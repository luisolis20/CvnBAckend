<?php

namespace App\Http\Controllers;
use App\Models\idioma;
use Illuminate\Http\Request;

class IdiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return idioma::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'idiomas.CIInfPer')
        ->select('idiomas.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
       
        
        
        $res = idioma::create($inputs);
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
        return idioma::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'idiomas.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('idiomas.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = idioma::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->idioma = $request->idioma;
            $res->comprension_auditiva = $request->comprension_auditiva;
            $res->comprension_lectura = $request->comprension_lectura;
            $res->interaccion_oral = $request->interaccion_oral;
            $res->expresion_oral = $request->expresion_oral;
            $res->expresion_escrita = $request->expresion_escrita;
            $res->certificado = $request->certificado;
           
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
                'mensaje'=>"Idioma con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = idioma::find($id);
        if(isset($res)){
            $elim = idioma::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"El Idioma no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El Idioma con id: $id no Existe",
            ]);
        }
    }
}
