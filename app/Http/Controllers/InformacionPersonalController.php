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


class InformacionPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtén los datos paginados
            $query = informacionpersonal::select('informacionpersonal.*');
            // Verificar si se solicita todos los datos sin paginación
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get();

                // Convertir los datos a UTF-8 válido
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if ($key === 'fotografia' && !empty($value)) {
                            // 🔥 Detectar tipo (opcional)
                            $mime = finfo_buffer(finfo_open(), $value, FILEINFO_MIME_TYPE);
                            if (strpos($mime, 'image') === false) {
                                $mime = 'image/jpeg'; // Valor por defecto
                            }

                            // ✅ Codificar correctamente para el navegador
                            $attributes[$key] = "data:$mime;base64," . base64_encode($value);
                        } elseif (is_string($value) && $key !== 'fotografia') {
                            $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $attributes;
                });

                return response()->json(['data' => $data]);
            }

            // Paginación por defecto
            $data = $query->paginate(20);

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron datos'], 404);
            }

            // Convertir los datos de cada página a UTF-8 válido
            $data->getCollection()->transform(function ($item) {
                $attributes = $item->getAttributes();
                foreach ($attributes as $key => $value) {
                    if (is_string($value)) {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $attributes;
            });

            // Retornar respuesta JSON con metadatos de paginación
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
                if ($key === 'fotografia' && !empty($value)) {
                    // ✅ Convertir BLOB a base64
                    $attributes[$key] = base64_encode($value);
                } elseif (is_string($value) && $key !== 'fotografia') {
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
        $request->validate([
            'fotografia' => 'required|string'
        ]);

        $persona = informacionpersonal::findOrFail($id);

        $imagenBase64 = $request->fotografia;

        // Si el string viene con encabezado "data:image/jpeg;base64,", lo eliminamos
        if (str_starts_with($imagenBase64, 'data:image')) {
            $imagenBase64 = explode(',', $imagenBase64)[1];
        }

        $persona->fotografia = base64_decode($imagenBase64);
        $persona->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto actualizada correctamente',
            'foto_base64' => $persona->foto_base64,
        ]);
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
