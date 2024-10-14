<?php

namespace App\Http\Controllers;
use App\Models\investigacion_publicacione;
use Illuminate\Http\Request;

class InvestigacionPublicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return investigacion_publicacione::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'investigacion_publicaciones.CIInfPer')
        ->select('investigacion_publicaciones.*') 
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
       
        
        
        $res = investigacion_publicacione::create($inputs);
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
        return investigacion_publicacione::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'investigacion_publicaciones.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
        ->select('investigacion_publicaciones.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = investigacion_publicacione::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->publicaciones = $request->publicaciones;
            $res->publicacion_tipo = $request->publicacion_tipo;
            $res->publicacion_titulo = $request->publicacion_titulo;
            $res->link_publicación = $request->link_publicación;
            $res->congreso_evento = $request->congreso_evento;
           
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
                'mensaje'=>"Investigacion con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = investigacion_publicacione::find($id);
        if(isset($res)){
            $elim = investigacion_publicacione::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Publicación no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Publicación con id: $id no Existe",
            ]);
        }
    }
}
