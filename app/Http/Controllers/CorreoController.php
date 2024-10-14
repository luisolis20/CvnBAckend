<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use Illuminate\Support\Str;

class CorreoController extends Controller
{
    public function generarCodigoVerificacion() {
        return Str::random(6);
    }
    public function validar($correo) {
        $regex = preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $correo);
        return $regex == true;
    }
    
    public function enviarCorreo(Request $request)
    { 
        $codigoVerificacion = $this->generarCodigoVerificacion();
       
        $correoDestino = $request->input('email');
        if (!$this->validar($correoDestino)) {
            return response()->json(['error' => 'Dirección de correo electrónico no válida'], 400);
        }
       
    
        try {
            // Envía el correo electrónico al destinatario especificado
            Mail::to($correoDestino)->send(new EnviarCorreo($codigoVerificacion));
    
            return response()->json(['data'=>$codigoVerificacion,
                'message' => 'Correo electrónico enviado con éxito'], 200);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el envío del correo electrónico
            return response()->json(['error' => 'Error al enviar el correo electrónico: ' . $e->getMessage()], 500);
        }
    }
}
