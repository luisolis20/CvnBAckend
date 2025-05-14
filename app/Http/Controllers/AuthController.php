<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\InformacionPersonald;
use App\Models\informacionpersonal;
use Illuminate\Validation\Rule;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CIInfPer' => 'required|string',
            'codigo_dactilar' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    
        $CIInfPer = $request->input('CIInfPer');
        $codigo_dactilar = $request->input('codigo_dactilar');
    
        // Buscar en InformacionPersonald (Docente)
        $resdocen = InformacionPersonald::where('LoginUsu', $CIInfPer)->first();
        if ($resdocen) {
            if (md5($codigo_dactilar) !== $resdocen->ClaveUsu) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Usuario correcto pero la clave es incorrecta',
                ], Response::HTTP_UNAUTHORIZED);
            }
    
            // Crear o actualizar usuario en users_cvn
            $user = User::updateOrCreate(
                ['email' => $resdocen->ApellInfPer],
                [
                    'name' => $resdocen->CIInfPer,
                    'password' => bcrypt($codigo_dactilar),
                    'role' => 'Docente',
                    'estado' => 1, // o el estado que tú definas por defecto
                ]
            );
    
            $token = auth()->login($user);
    
            return response()->json([
                'mensaje' => 'Autenticación exitosa',
                'Rol' => 'Docente',
                'CIInfPer' => $resdocen->CIInfPer,
                'ApellInfPer' => $resdocen->ApellInfPer,
                'mailPer' => $resdocen->mailPer,
                'token' => $token,
                'token_type' => 'bearer'
            ]);
        }
    
        // Buscar en InformacionPersonal (Estudiante)
        $res = informacionpersonal::where('CIInfPer', $CIInfPer)->first();
        if ($res) {
            if (md5($codigo_dactilar) !== $res->codigo_dactilar) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Usuario correcto pero la clave es incorrecta',
                ], Response::HTTP_UNAUTHORIZED);
            }
    
            // Crear o actualizar usuario en users_cvn
            $user = User::updateOrCreate(
                ['email' => $res->ApellInfPer],
                [
                    'name' => $res->CIInfPer,
                    'password' => bcrypt($codigo_dactilar),
                    'role' => 'Estudiante',
                    'estado' => 1,
                ]
            );
    
            $token = auth()->login($user);
    
            return response()->json([
                'mensaje' => 'Autenticación exitosa',
                'Rol' => 'Estudiante',
                'CIInfPer' => $res->CIInfPer,
                'ApellInfPer' => $res->ApellInfPer,
                'mailPer' => $res->mailPer,
                'token' => $token,
                'token_type' => 'bearer'
            ]);
        }
    
        // Buscar en tabla users_cvn directamente
        $user = User::where('email', $CIInfPer)->first();
        if ($user) {
            if ($user->estado !== 1) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'El usuario está inhabilitado',
                ], Response::HTTP_UNAUTHORIZED);
            }
    
            if (!Hash::check($codigo_dactilar, $user->password)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Usuario correcto pero la clave es incorrecta',
                ], Response::HTTP_UNAUTHORIZED);
            }
    
            $token = auth()->login($user);
    
            return response()->json([
                'mensaje' => 'Autenticación exitosa',
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'name' => $user->name,
                'email' => $user->email,
                'id' => $user->id,
                'Rol' => $user->role,
            ]);
        }
    
        return response()->json([
            'error' => true,
            'mensaje' => "El Usuario: $CIInfPer no Existe",
        ], Response::HTTP_NOT_FOUND);
    }
   
    public function me(){
        return response()->json(auth()->user());
    }
    public function logout(){
        auth()->logout();
        try{
            $token = JWTAuth::getToken();
            if(!$token){
                return response()->json(['error'=>'No hay token'],Response::HTTP_BAD_REQUEST);
            }
            JWTAuth::invalidate($token);
            return response()->json(['message'=>'Has cerrado sesion'],Response::HTTP_OK);
        }catch(TokenInvalidException $e){
            return response()->json(['error'=>'Token inválido'],Response::HTTP_UNAUTHORIZED);
        }catch(\Exception $e){
            return response()->json(['error'=>'No se pudo cerrar sesion'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function refresh(){
        try{
            $token = JWTAuth::getToken();
            if(!$token){
                return response()->json(['error'=>'No hay token'],Response::HTTP_BAD_REQUEST);
            }
            $nuevo_token = auth()->refresh();
            JWTAuth::invalidate($token);
            return $this->respondWithToken($nuevo_token);
        }catch(TokenInvalidException $e){
            return response()->json(['error'=>'Token inválido'],Response::HTTP_UNAUTHORIZED);
        }catch(\Exception $e){
            return response()->json(['error'=>'No se pudo refrescar sesion'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    protected function respondWithToken($token){
        return response()->json([
            'token'=>$token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ],Response::HTTP_OK);
    }
}
