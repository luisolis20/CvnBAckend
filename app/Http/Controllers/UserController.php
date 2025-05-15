<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        if(!isset($inputs['role'])){
            $inputs['role']='Estudiante';
        }
        if(!isset($inputs['estado'])){
            $inputs['estado']=1;
        }
        
        $inputs["password"] = Hash::make(trim($request->password)); 
        $res = User::create($inputs);
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
        $res = User::find($id);
        if(isset($res)){
            return response()->json([
                'data'=>$res,
                'mensaje'=>"Encontrado con Éxito!!",
            ]);
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El Usuario con id: $id no Existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = User::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->name = $request->name;
            $res->email = $request->email;
            $res->password = Hash::make($request->password);
            $res->role = $request->role;
            $res->estado = $request->estado;
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
                'mensaje'=>"El Usuario con id: $id no Existe",
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
    /**
     * Metodo para loguearse con un usuar
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::select('id','name','email','role','estado','password')
        ->where('email', $email)
        ->first();
        
        if ($user->estado !== 1) {
            return response()->json([
                'error' => true,
                'mensaje' => 'El usuario está inhabilitado',
            ]);
        }
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Credenciales inválidas',
            ]);
        }

        $token = $user->createToken('customToken')->accessToken;

        return response()->json([
            'mensaje' => 'Autenticación exitosa',
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
            'role' => $user->role,
        ]);
    }
    public function eliminarus(string $id)
    {
        $res = User::find($id);
        if(isset($res)){
          
            $res->estado = 0;
            if($res->save()){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Estado del Usuario es Deshabilitado!!",
                ]);
            }
            else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>"Error al Eliminar",
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El Usuario con id: $id no Existe",
            ]);
        }
    }
}
