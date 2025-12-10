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
use App\Http\Controllers\DeclaracionPersonalConsulta;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroTituloController;
use App\Http\Controllers\CvnValidacionController;
use App\Http\Controllers\Declaracion_PersonalDocentesController;
use App\Http\Controllers\Academico_DocenteController;
use App\Http\Controllers\PeriodoLectivoController;
use App\Http\Controllers\Inst_Ed_SupController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\SubAreaUnescoController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\CursaEstudiosController;



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
Route::prefix('cvn')->group(function () {

    //Route::post('/login', [UserController::class, 'login']);
    //Route::post('/login2', [InformacionPersonalController::class, 'login']);
    Route::post('v1/enviar-correo', [CorreoController::class, 'enviarCorreo'])->middleware('throttle:10000,1');
    Route::post('v1/enviar-comentario', [EnviarComentarioController::class, 'enviarComentario'])->middleware('throttle:10000,1');
    Route::post('v1/recuperar-clave', [RecuperarClaveController::class, 'recuperarclave'])->middleware('throttle:10000,1');
    
    Route::get('v1/verificar/{codigo}', [CvnValidacionController::class, 'verificar'])->middleware('throttle:10000,1');
    Route::get('v1/verficiar_cvn/{codigo}', [InformacionPersonalController::class, 'verificar'])->middleware('throttle:10000,1');
    Route::get('v1/cvcompleto/{codigo}', [InformacionPersonalController::class, 'getCvCompleto'])->middleware('throttle:10000,1');
    Route::get('v1/obtenerdata', [InformacionPersonalController::class, 'obtenerdata'])->middleware('throttle:10000,1');
    Route::put('v1/actualizarFoto/{codigo}', [InformacionPersonalController::class, 'actualizarFoto'])->middleware('throttle:10000,1');
    Route::get('v1/infromaciondata/{id}', [InformacionPersonalController::class, 'show'])->middleware('throttle:10000,1');
    Route::get('v1/getCVNstatusInd/{id}', [InformacionPersonalController::class, 'getCVNstatusInd'])->middleware('throttle:10000,1');
    Route::get('/v1/informacionpersonal/{ci}/foto', [InformacionPersonalController::class, 'getFotografia'])->middleware('throttle:10000,1');
    //Login
    
    //Route::apiResource('v1/informacionpersonal', InformacionPersonalController::class);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::apiResource("v1/users", UserController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/formacion_academica', FormacionAcademicaController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/informacionpersonal', InformacionPersonalController::class)->middleware('throttle:10000,1');
        Route::put('v1/eliminar/{id}', [UserController::class, 'eliminarus'])->middleware('throttle:10000,1');
        Route::apiResource('v1/datos_personales', DatosPersonalesController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/declaracion_personal', DeclaracionPersonalController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/experiencia_profesionale', Experiencia_ProController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/habilidades_informatica', HabilidadesInformaticaController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/idioma', IdiomaController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/informacion_contacto', InformacionContactoController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/investigacion_publicacione', InvestigacionPublicacionesController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/otros_datos_relevante', OtrosDatosController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/cursoscapacitacion', CursoCapacitaciones::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/fichasocioeconomica', FichaSocioEconomicaController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/sicvn', DeclaracionPersonalConsulta::class)->middleware('throttle:10000,1');
        Route::get('v1/titulog/{id}', [RegistroTituloController::class, 'titulog'])->middleware('throttle:10000,1');
        Route::get('v1/checkUpdateStatus/{CIInfPer}', [InformacionPersonalController::class, 'checkUpdateStatus'])->middleware('throttle:10000,1');
        Route::get('v1/titulogPosgrados/{id}', [RegistroTituloController::class, 'titulogPosgrados'])->middleware('throttle:10000,1');
        Route::post('v1/validar', [CvnValidacionController::class, 'store'])->middleware('throttle:10000,1');
        Route::get('v1/historialDe/{id}', [CvnValidacionController::class, 'show'])->middleware('throttle:10000,1');
        
        //Docentes
        
        Route::apiResource('v1/informacionpersonald', InformacionPersonal_DController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/declaracion_personalD', Declaracion_PersonalDocentesController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/academico_docente', Academico_DocenteController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/cursa_estudios', CursaEstudiosController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/inst_educ_sup', Inst_Ed_SupController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/nivel', NivelController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/pais', PaisController::class)->middleware('throttle:10000,1');
        Route::apiResource('v1/subarea_conocimiento', SubAreaUnescoController::class)->middleware('throttle:10000,1');
        Route::get('v1/periodos_activos', [PeriodoLectivoController::class, 'getActivos'])->middleware('throttle:10000,1');
        Route::post('v1/upload_titulo', [Academico_DocenteController::class, 'uploadTitulo'])->middleware('throttle:10000,1');
        Route::post('v1/upload_cursa', [CursaEstudiosController::class, 'uploadCursaEstudios'])->middleware('throttle:10000,1');
        Route::apiResource('v1/publicacion_art_docente', Publicacion_articulo_docenteController::class);
        Route::apiResource('v1/publicacion_lb_docente', Publicacion_Libro_DocenteController::class);
        Route::apiResource('v1/capacitacion_docente', CapacitacionDocentesController::class);
    });
});
