<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperarClave;
use Illuminate\Support\Str;
use App\Models\User;

class RecuperarClaveController extends Controller
{
    public function validar($correo) {
        $regex = preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $correo);
        return $regex == true;
    }
   
    
    public function recuperarclave(Request $request)
    { 
        try {
            
            $email = $request->input('email');

            $user = User::select('estado','password')
            ->where('email', $email)
            ->first();
            $claverecuperada=$user->password;
            
            
            
            if (!$this->validar($email)) {
                return response()->json(['error' => 'Dirección de correo electrónico no válida'], 400);
            }
            // Envía el correo electrónico al destinatario especificado
            Mail::to($email)->send(new RecuperarClave($claverecuperada));
            if ($user->estado !== 1) {
                return response()->json(['data'=>$claverecuperada,
                'message' => 'Su usuario Está Inhabilitado -- Correo electrónico enviado con éxito'], 200);
            }else{
                return response()->json(['data'=>$claverecuperada,
                'message' => 'Correo electrónico enviado con éxito'], 200);
            }
        
    
        
            
    
            
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el envío del correo electrónico
            return response()->json(['error' => 'Error al enviar el correo electrónico: ' . $e->getMessage()], 500);
        }
    }
}
