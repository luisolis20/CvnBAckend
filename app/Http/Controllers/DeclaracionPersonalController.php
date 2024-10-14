<?php

namespace App\Http\Controllers;
use App\Models\declaracion_personal;
use Illuminate\Http\Request;

class DeclaracionPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return declaracion_personal::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'declaracion_personals.CIInfPer')
        ->select('declaracion_personals.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        $res = declaracion_personal::create($inputs);
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
        return declaracion_personal::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'declaracion_personals.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('declaracion_personals.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = declaracion_personal::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->texto = $request->texto;
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
                'mensaje'=>"Declaracion personal con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
