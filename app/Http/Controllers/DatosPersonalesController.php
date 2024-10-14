<?php

namespace App\Http\Controllers;
use App\Models\datos_personale;
use Illuminate\Http\Request;

class DatosPersonalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return datos_personale::join('users', 'users.id', '=', 'datos_personales.user_id')
        ->where('users.estado', 1)
        ->select('datos_personales.*') 
        ->get();
       
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        if(!isset($inputs['nombres_apellidos'])){
            $inputs['nombres_apellidos']=' ';
        }
        if(!isset($inputs['num_identificacion'])){
            $inputs['num_identificacion']='0000000000';
        }
        if(!isset($inputs['fecha_nacimiento'])){
            $inputs['fecha_nacimiento']='1990-09-01';
        }
        if(!isset($inputs['genero'])){
            $inputs['genero']=' ';
        }
        if(!isset($inputs['estado_civil'])){
            $inputs['estado_civil']=' ';
        }
        if(!isset($inputs['direccion_residencia'])){
            $inputs['direccion_residencia']=' ';
        }
        if(!isset($inputs['telefono'])){
            $inputs['telefono']='000000000';
        }
        if(!isset($inputs['correo_electronico'])){
            $inputs['correo_electronico']='example@example.com';
        }
        
        
        $res = datos_personale::create($inputs);
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
        return datos_personale::join('users', 'users.id', '=', 'datos_personales.user_id')
        ->where('users.id', $id)
        ->select('datos_personales.*') 
        ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = datos_personale::find($id);
        if(isset($res)){
            $res->user_id = $request->user_id;
            $res->nombres_apellidos = $request->nombres_apellidos;
            $res->num_identificacion = $request->num_identificacion;
            $res->fecha_nacimiento = $request->fecha_nacimiento;
            $res->genero = $request->genero;
            $res->direccion_residencia = $request->direccion_residencia;
            $res->telefono = $request->telefono;
            $res->correo_electronico = $request->correo_electronico;
            $res->foto = $request->foto;
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
                'mensaje'=>"Dato personal con id: $id no Existe",
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
