<?php

namespace App\Http\Controllers;
use App\Models\Declaracion_Personal_D;
use Illuminate\Http\Request;

class Declaracion_PersonalDocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Declaracion_Personal_D::join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'declaracion_personal_docentes.CIInfPer')
        ->select('declaracion_personal_docentes.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        $res = Declaracion_Personal_D::create($inputs);
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
        return Declaracion_Personal_D::join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'declaracion_personal_docentes.CIInfPer')
        ->where('informacionpersonal_d.CIInfPer', $id)
        ->select('declaracion_personal_docentes.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = Declaracion_Personal_D::find($id);
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
