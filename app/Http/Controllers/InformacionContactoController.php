<?php

namespace App\Http\Controllers;
use App\Models\informacion_contacto;
use Illuminate\Http\Request;

class InformacionContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return informacion_contacto::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'informacion_contactos.CIInfPer')
        ->select('informacion_contactos.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        
        
        
        $res = informacion_contacto::create($inputs);
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
        return informacion_contacto::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'informacion_contactos.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('informacion_contactos.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = informacion_contacto::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->referencia_nombres = $request->referencia_nombres;
            $res->referencia_apellidos = $request->referencia_apellidos;
            $res->referencia_correo_electronico = $request->referencia_correo_electronico;
            $res->referencia_telefono = $request->referencia_telefono;
           
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
                'mensaje'=>"Informacion de Contacto con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = informacion_contacto::find($id);
        if(isset($res)){
            $elim = informacion_contacto::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Referencia Personal no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Referencia Personal con id: $id no Existe",
            ]);
        }
    }
}
