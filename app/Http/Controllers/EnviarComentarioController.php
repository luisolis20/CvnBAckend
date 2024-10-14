<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarComentario;
use Illuminate\Support\Str;

class EnviarComentarioController extends Controller
{
    public function validar($correo) {
        $regex = preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $correo);
        return $regex == true;
    }
    public function enviarComentario(Request $request)
    {
        $nombre = $request->input('nombre');
        $correo = $request->input('correo');
        $mensaje = $request->input('mensaje');
        if (!$this->validar($correo)) {
            return response()->json(['error' => 'Dirección de correo electrónico no válida'], 400);
        }else{
            try {
                // Envía el correo electrónico al destinatario especificado
                Mail::to('cvn.utelvt@gmail.com')->send(new EnviarComentario($nombre, $correo, $mensaje));
        
                return response()->json(['message' => 'Comentario enviado con éxito'], 200);
            } catch (\Exception $e) {
                // Maneja cualquier error que ocurra durante el envío del correo electrónico
                return response()->json(['error' => 'Error al enviar el correo electrónico: ' . $e->getMessage()], 500);
            }

        }
    }
}
