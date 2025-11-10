<?php

namespace App\Http\Controllers;

use App\Models\curso_capacitacion;
use App\Models\informacionpersonal;
use App\Models\User;
use App\Models\InformacionPersonald;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\declaracion_personal;
use App\Models\experiencia_profesionale;
use App\Models\formacion_academica;
use App\Models\habilidades_informatica;
use App\Models\idioma;
use App\Models\informacion_contacto;
use App\Models\investigacion_publicacione;
use App\Models\otros_datos_relevante;
use App\Models\FichaSocioeconomica;
use App\Models\RegistroTitulos;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class InformacionPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Lista de modelos a verificar para el CVN
        $cvnModels = [
            declaracion_personal::class,
            experiencia_profesionale::class,
            formacion_academica::class,
            habilidades_informatica::class,
            idioma::class,
            informacion_contacto::class,
            investigacion_publicacione::class,
            otros_datos_relevante::class,
        ];
        $totalTablas = count($cvnModels);

        try {
            if ($request->has('all') && $request->all === 'true') {

                // 1. OBTENER EL CONTEO TOTAL DE USUARIOS antes de filtrar
                $totalUsers = informacionpersonal::count();

                // 2. IDENTIFICAR USUARIOS QUE HAN INICIADO EL CVN 
                //    (tienen al menos 1 registro en cualquiera de las tablas CVN).
                $ciWithData = collect();
                // Iteramos sobre las 8 tablas para colectar todos los CI que tienen datos
                foreach ($cvnModels as $model) {
                    // Seleccionamos los CIInfPer distintos que tienen registros en esta tabla
                    $cis = $model::select('CIInfPer')->distinct()->pluck('CIInfPer');
                    $ciWithData = $ciWithData->merge($cis);
                }
                $ciWithData = $ciWithData->unique()->toArray(); // Lista final de CI que han iniciado CVN

                // 3. FILTRAR LA CONSULTA PRINCIPAL: SOLO usuarios que aparecen en alguna tabla CVN
                $query = informacionpersonal::select('informacionpersonal.*')
                    ->whereIn('CIInfPer', $ciWithData);

                $data = $query->get();

                // 4. CALCULAR EL CONTEO DE USUARIOS OMITIDOS (sin CVN)
                $omittedCount = $totalUsers - $data->count();

                // 5. OBTENER CONTEOS DE FORMA EFICIENTE
                // Creamos un mapa de conteos para CADA tabla, para todos los usuarios.
                $ciList = $data->pluck('CIInfPer')->toArray();
                $ciCounts = [];

                // Mapear el total de tablas completadas por cada CIInfPer
                foreach ($ciList as $ci) {
                    $ciCounts[$ci] = 0; // Inicializar
                }

                // Ejecutamos solo una consulta por modelo (N consultas en total)
                foreach ($cvnModels as $model) {
                    $results = $model::whereIn('CIInfPer', $ciList)
                        ->groupBy('CIInfPer')
                        ->selectRaw('CIInfPer, count(*) as total')
                        ->get();

                    foreach ($results as $result) {
                        // Si hay al menos un registro en esta tabla, se considera "con datos"
                        if ($result->total > 0) {
                            $ciCounts[$result->CIInfPer]++;
                        }
                    }
                }

                // 6. APLICAR TRANSFORMACIÓN DE DATOS Y ESTADO
                $data->transform(function ($item) use ($totalTablas, $ciCounts) {
                    $attributes = $item->getAttributes();
                    $ci = $attributes['CIInfPer'];
                    // Como el usuario ya está filtrado, totalConDatos siempre será >= 1 si la lógica de filtrado fue correcta.
                    $totalConDatos = $ciCounts[$ci] ?? 0;

                    // Lógica de estado CVN: Ya no puede ser 'No ha hecho CVN'
                    if ($totalConDatos === $totalTablas) {
                        $estado = 'Completado';
                    } else {
                        $estado = 'Incompleto';
                    }
                    $attributes['completionStatus'] = $estado; // Añadir el nuevo campo de estado

                    // Lógica para fotografía (BLOB a Base64) - Esto es lo que se optimiza al reducir el dataset
                    if (!empty($attributes['fotografia'])) {
                        $value = $attributes['fotografia'];
                        // Intentar obtener el MIME type, si falla o no es una imagen, usar un MIME por defecto
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime = $finfo ? finfo_buffer($finfo, $value) : 'image/jpeg';
                        if ($finfo) finfo_close($finfo);

                        // Asegurar que el MIME type es de imagen, si no, usar el defecto
                        if (strpos($mime, 'image') === false) {
                            $mime = 'image/jpeg';
                        }
                        $attributes['fotografia'] = "data:$mime;base64," . base64_encode($value);
                    } else {
                        $attributes['fotografia'] = null;
                    }

                    // Conversión UTF-8 (mantener si es necesario)
                    foreach ($attributes as $key => $value) {
                        if (is_string($value) && $key !== 'fotografia') {
                            $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }

                    return $attributes;
                });

                // 7. DEVOLVER LA RESPUESTA CON EL CONTEO DE USUARIOS OMITIDOS
                return response()->json([
                    'data' => $data,
                    'omittedCount' => $omittedCount,
                ]);
            }

            // ... (Lógica de paginación por defecto, si aplica)
            // ... (Se recomienda aplicar la lógica de estado también en el caso de paginación)

            return response()->json(['error' => 'La paginación sin el flag "all" no está completamente implementada con status'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();


        $inputs["codigo_dactilar"] = md5(trim($request->codigo_dactilar));
        $res = informacionpersonal::create($inputs);
        return response()->json([
            'data' => $res,
            'mensaje' => "Agregado con Éxito!!",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Aplica paginación al resultado del filtro
        $data = informacionpersonal::select('informacionpersonal.*')
            ->where('informacionpersonal.CIInfPer', $id)
            ->paginate(20);
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();

            foreach ($attributes as $key => $value) {
                if (in_array($key, ['fotografia']) && !empty($value)) {
                    // ✅ Convertir BLOB a base64
                    $attributes[$key] = base64_encode($value);
                } elseif (is_string($value) && !in_array($key, ['fotografia', 'logo', 'fotografia2'])) {
                    $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }

            return $attributes;
        });

        // Retornar la respuesta JSON con los metadatos de paginación
        try {
            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al codificar los datos a JSON: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = informacionpersonal::find($id);

        if (!isset($res)) {
            return response()->json([
                'error' => true,
                'mensaje' => "El registro con id: $id no Existe",
            ]);
        }

        $updateData = [];

        // --- SOLUCIÓN FINAL Y DEFINITIVA PARA BLOB (Usando DB::raw) ---
        if (!empty($request->fotografia)) {
            // 1. Decodificar la cadena Base64 a datos binarios puros.
            $binaryData = base64_decode($request->fotografia);

            // 2. Envolver los datos binarios en DB::raw(). Esto le dice a PDO que NO
            // trate el valor como una cadena UTF-8, sino como el binario que es.
            $updateData['fotografia'] = DB::raw("FROM_BASE64('" . base64_encode($binaryData) . "')");

            // Nota: Este truco requiere que MySQL decodifique, pero en el backend de Laravel
            // solo necesitamos el DB::raw. Si estás usando SQLite o PostgreSQL, el enfoque cambia.
            // Para MySQL, esta es la forma más limpia de forzar el binario sin errores de PHP.
            // Una forma más universal para Laravel/MySQL es:

            // $updateData['fotografia'] = $binaryData; // Asignamos el binario decodificado.

            // Y luego usamos un update directo sobre el Query Builder para aplicar el binario.
            // Si solo actualizas la foto, usa la siguiente lógica:
            try {
                // Usamos el Query Builder para asegurarnos de que el binario se maneje correctamente.
                // Es crucial para datos BLOB.
                DB::table('informacionpersonal')
                    ->where('CIInfPer', $id)
                    ->update(['fotografia' => $binaryData]);

                // Recargar el modelo para que la respuesta JSON incluya la foto actualizada
                $res = informacionpersonal::find($id);

                $data = $res->toArray();

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Actualizado con Éxito!!",
                ]);
            } catch (\Exception $e) {
                // Si falla por cualquier razón (ej. timeout, db error), capturamos aquí
                return response()->json([
                    'error' => true,
                    'mensaje' => "Error al Actualizar la foto: " . $e->getMessage(),
                ], 500);
            }
        }

        // Si no hay foto en el request, asumimos que no hay nada que actualizar.
        // Si tienes otros campos que actualizar, esta lógica DEBE ser más compleja.

        return response()->json([
            'error' => true,
            'mensaje' => "No se proporcionó la fotografía para actualizar.",
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $CIInfPer = $request->input('CIInfPer');
        $codigo_dactilar = $request->input('codigo_dactilar');

        $resdocen = InformacionPersonald::select('CIInfPer', 'LoginUsu', 'ClaveUsu', 'ApellInfPer', 'mailPer')
            ->where('LoginUsu', $CIInfPer)
            ->first();

        $res = informacionpersonal::select('CIInfPer', 'codigo_dactilar', 'ApellInfPer', 'mailPer')
            ->where('CIInfPer', $CIInfPer)
            ->first();

        $user = User::select('id', 'name', 'email', 'role', 'estado', 'password')
            ->where('email', $CIInfPer)
            ->first();

        if ($resdocen) {
            if (md5($codigo_dactilar) !== $resdocen->ClaveUsu) {
                return response()->json([
                    'error' => true,
                    'clave' => 'clave error',
                    'mensaje' => 'El usuario es correcto pero hay un error en la clave',
                ]);
            }
            return response()->json([
                'mensaje' => 'Autenticación exitosa',
                'Rol' => 'Docente',
                'CIInfPer' => $resdocen->CIInfPer,
                'ApellInfPer' => $resdocen->ApellInfPer,
                'mailPer' => $resdocen->mailPer,
            ]);
        } elseif ($res) {
            if (md5($codigo_dactilar) !== $res->codigo_dactilar) {
                return response()->json([
                    'error' => true,
                    'clave' => 'clave error',
                    'mensaje' => 'El usuario es correcto pero hay un error en la clave',
                ]);
            }
            return response()->json([
                'mensaje' => 'Autenticación exitosa',
                'Rol' => 'Estudiante',
                'CIInfPer' => $res->CIInfPer,
                'ApellInfPer' => $res->ApellInfPer,
                'mailPer' => $res->mailPer,
            ]);
        } elseif ($user) {
            if ($user->estado !== 1) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'El usuario está inhabilitado',
                ]);
            }
            if (!Hash::check($codigo_dactilar, $user->password)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'El usuario es correcto pero hay un error en la clave',
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
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El Usuario : $CIInfPer no Existe",
            ]);
        }
    }
    public function getCvCompleto($id)
    {
        try {
            $cv = [];

            // ✅ Información personal (con foto base64)
            $infoper = InformacionPersonal::where('CIInfPer', $id)->first();

            if ($infoper) {
                $attributes = $infoper->getAttributes();

                foreach ($attributes as $key => $value) {
                    if ($key === 'fotografia' && !empty($value)) {
                        $attributes[$key] = base64_encode($value);
                    } elseif (is_string($value) && $key !== 'fotografia') {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }

                $cv['informacion_personal'] = $attributes;
            } else {
                $cv['informacion_personal'] = null;
            }

            // Formación académica
            $cv['formacion_academica'] = formacion_academica::where('CIInfPer', $id)->get();

            // Ficha socioeconómica (por si se usa)
            $cv['ficha_socioeconomica'] = FichaSocioeconomica::where('CIInfPer', $id)->first();

            // Experiencia profesional
            $cv['experiencias_profesionales'] = experiencia_profesionale::where('CIInfPer', $id)->get();

            // Investigación y publicaciones
            $cv['investigacion_publicaciones'] = investigacion_publicacione::where('CIInfPer', $id)->get();

            // Idiomas
            $cv['idiomas'] = Idioma::where('CIInfPer', $id)->get();

            // Habilidades informáticas
            $cv['habilidades_informaticas'] = habilidades_informatica::where('CIInfPer', $id)->get();

            // Cursos y capacitaciones
            $cv['cursos_capacitacion'] = curso_capacitacion::where('CIInfPer', $id)->get();

            // Otros datos relevantes
            $cv['otros_datos_relevantes'] = otros_datos_relevante::where('CIInfPer', $id)->get();

            // Información de contacto
            $cv['informacion_contacto'] = informacion_contacto::where('CIInfPer', $id)->get();

            // Declaración personal
            $cv['declaracion_personal'] = declaracion_personal::where('CIInfPer', $id)->first();

            // Títulos de grado y posgrado (de sistema externo)
            $cv['titulos_grado'] = RegistroTitulos::select(
                'registrotitulos.*',
                'carrera.*'
            )
                ->join('carrera', 'carrera.idCarr', '=', 'registrotitulos.idcarr')
                ->where('registrotitulos.ciinfper', $id)
                ->where('carrera.idfacultad', '!=', 6)->get();
            $cv['titulos_posgrado'] = RegistroTitulos::select(
                'registrotitulos.*',
                'carrera.*'
            )
                ->join('carrera', 'carrera.idCarr', '=', 'registrotitulos.idcarr')
                ->where('registrotitulos.ciinfper', $id)
                ->where('carrera.idfacultad', 6)->get();

            // Retornar todo en una sola respuesta JSON
            return response()->json([
                'success' => true,
                'data' => $cv
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos del CV completo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function verificar($ci)
    {
        // Verificar que exista información personal
        $infoper = informacionpersonal::where('CIInfPer', $ci)->first();

        if (!$infoper) {
            return response()->json([
                'estado' => 'No ha llenado CVN',
                'mensaje' => 'No existe registro en información personal',
            ]);
        }

        // Verificar si tiene datos en las tablas relacionadas
        $checks = [
            'declaracion_personal'      => declaracion_personal::where('CIInfPer', $ci)->exists(),
            'experiencia_profesional'   => experiencia_profesionale::where('CIInfPer', $ci)->exists(),
            'formacion_academica'       => formacion_academica::where('CIInfPer', $ci)->exists(),
            'habilidades_informatica'   => habilidades_informatica::where('CIInfPer', $ci)->exists(),
            'idioma'                    => idioma::where('CIInfPer', $ci)->exists(),
            'informacion_contacto'      => informacion_contacto::where('CIInfPer', $ci)->exists(),
            'investigacion_publicacion' => investigacion_publicacione::where('CIInfPer', $ci)->exists(),
            'otros_datos_relevante'     => otros_datos_relevante::where('CIInfPer', $ci)->exists(),
        ];

        $totalTablas = count($checks);
        $totalConDatos = collect($checks)->filter()->count();

        // Determinar el estado del CVN
        if ($totalConDatos === 0) {
            $estado = 'No ha llenado CVN';
        } elseif ($totalConDatos === $totalTablas) {
            $estado = 'CVN completo';
        } else {
            $estado = 'CVN incompleto';
        }

        return response()->json([
            'estado' => $estado,
            'detalle' => $checks,
            'total_con_datos' => $totalConDatos,
            'total_tablas' => $totalTablas,
        ]);
    }
}
