<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\RecuperarClaveController;
use App\Http\Controllers\DatosPersonalesController;
use App\Http\Controllers\DeclaracionPersonalController;
use App\Http\Controllers\Experiencia_ProController;
use App\Http\Controllers\FormacionAcademicaController;
use App\Http\Controllers\HabilidadesInformaticaController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\InformacionContactoController;
use App\Http\Controllers\InvestigacionPublicacionesController;
use App\Http\Controllers\OtrosDatosController;
use App\Http\Controllers\InformacionPersonalController;
use App\Http\Controllers\CursoCapacitaciones;
use App\Http\Controllers\EnviarComentarioController;
use App\Http\Controllers\FichaSocioEconomicaController;
use App\Http\Controllers\InformacionPersonal_DController;
use App\Http\Controllers\Publicacion_articulo_docenteController;
use App\Http\Controllers\Publicacion_Libro_DocenteController;
use App\Http\Controllers\CapacitacionDocentesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("v1/users",UserController::class);
Route::post('/login', [UserController::class, 'login']);
Route::post('/login2', [InformacionPersonalController::class, 'login']);
Route::post('v1/enviar-correo', [CorreoController::class, 'enviarCorreo']);
Route::post('v1/enviar-comentario', [EnviarComentarioController::class, 'enviarComentario']);
Route::post('v1/recuperar-clave', [RecuperarClaveController::class, 'recuperarclave']);
Route::put('v1/eliminar/{id}', [UserController::class, 'eliminarus']);
Route::apiResource('v1/datos_personales', DatosPersonalesController::class);
Route::apiResource('v1/declaracion_personal', DeclaracionPersonalController::class);
Route::apiResource('v1/experiencia_profesionale', Experiencia_ProController::class);
Route::apiResource('v1/formacion_academica', FormacionAcademicaController::class);
Route::apiResource('v1/habilidades_informatica', HabilidadesInformaticaController::class);
Route::apiResource('v1/idioma', IdiomaController::class);
Route::apiResource('v1/informacion_contacto', InformacionContactoController::class);
Route::apiResource('v1/investigacion_publicacione', InvestigacionPublicacionesController::class);
Route::apiResource('v1/otros_datos_relevante', OtrosDatosController::class);
Route::apiResource('v1/informacionpersonal', InformacionPersonalController::class);
Route::apiResource('v1/cursoscapacitacion', CursoCapacitaciones::class);
Route::apiResource('v1/fichasocioeconomica', FichaSocioEconomicaController::class);

//Docentes

Route::apiResource('v1/informacionpersonald', InformacionPersonal_DController::class);
Route::apiResource('v1/publicacion_art_docente', Publicacion_articulo_docenteController::class);
Route::apiResource('v1/publicacion_lb_docente', Publicacion_Libro_DocenteController::class);
Route::apiResource('v1/capacitacion_docente', CapacitacionDocentesController::class);
