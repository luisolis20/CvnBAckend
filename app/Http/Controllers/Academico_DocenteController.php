<?php

namespace App\Http\Controllers;

use App\Models\AcademicoDocente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Academico_DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = AcademicoDocente::select(
                'academico_docente.*',
                'informacionpersonal_d.ApellInfPer',
                'informacionpersonal_d.ApellMatInfPer',
                'informacionpersonal_d.NombInfPer',
                'inst_educ_sup.*',
                'pais.*',
                'nivel.*',
                'periodolectivo.*',
                'subarea_unesco.*',
            )
                ->join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'academico_docente.ciinfper')
                ->join('inst_educ_sup', 'inst_educ_sup.cod_ies', '=', 'academico_docente.ad_institucion')
                ->join('pais', 'pais.cod_pais', '=', 'academico_docente.ad_pais')
                ->join('nivel', 'nivel.nv_id', '=', 'academico_docente.nv_id')
                ->join('periodolectivo', 'periodolectivo.idper', '=', 'academico_docente.idper')
                ->join('subarea_unesco', 'subarea_unesco.sau_id', '=', 'academico_docente.sub_area_conocimiento');
            // Verificar si se solicita todos los datos sin paginación
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get();

                // Convertir los datos a UTF-8 válido
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if (is_string($value)) {
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
                return response()->json([
                    'data' => [],
                    'message' => 'No se encontraron datos',
                ], 200);
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


        $res = AcademicoDocente::create($inputs);
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
        $data = AcademicoDocente::select(
            'academico_docente.*',
            'informacionpersonal_d.ApellInfPer',
            'informacionpersonal_d.ApellMatInfPer',
            'informacionpersonal_d.NombInfPer',
            'inst_educ_sup.*',
            'pais.*',
            'nivel.*',
            'subarea_unesco.*',
        )
            ->join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'academico_docente.ciinfper')
            ->join('inst_educ_sup', 'inst_educ_sup.cod_ies', '=', 'academico_docente.ad_institucion')
            ->join('pais', 'pais.cod_pais', '=', 'academico_docente.ad_pais')
            ->join('nivel', 'nivel.nv_id', '=', 'academico_docente.nv_id')
            ->join('subarea_unesco', 'subarea_unesco.sau_id', '=', 'academico_docente.sub_area_conocimiento')
            ->where('nivel.nv_numnivel', 3)
            ->where('informacionpersonal_d.CIInfPer', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No se encontraron datos para el ID especificado',
            ], 200);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (is_string($value)) {
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
    public function titulospopsgradog(string $id)
    {
        $data = AcademicoDocente::select(
            'academico_docente.*',
            'informacionpersonal_d.ApellInfPer',
            'informacionpersonal_d.ApellMatInfPer',
            'informacionpersonal_d.NombInfPer',
            'inst_educ_sup.*',
            'pais.*',
            'nivel.*',
            'subarea_unesco.*',
        )
            ->join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'academico_docente.ciinfper')
            ->join('inst_educ_sup', 'inst_educ_sup.cod_ies', '=', 'academico_docente.ad_institucion')
            ->join('pais', 'pais.cod_pais', '=', 'academico_docente.ad_pais')
            ->join('nivel', 'nivel.nv_id', '=', 'academico_docente.nv_id')
            ->join('subarea_unesco', 'subarea_unesco.sau_id', '=', 'academico_docente.sub_area_conocimiento')
            ->where('nivel.nv_numnivel', 4)
            ->where('informacionpersonal_d.CIInfPer', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No se encontraron datos para el ID especificado',
            ], 200);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (is_string($value)) {
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
        $res = AcademicoDocente::find($id);
        if (isset($res)) {
            $res->ciinfper = $request->ciinfper;
            $res->idper = $request->idper;
            $res->ad_titulo = $request->ad_titulo;
            $res->ad_institucion = $request->ad_institucion;
            $res->ad_pais = $request->ad_pais;
            $res->ad_fecha_titulo = $request->ad_fecha_titulo;
            $res->ad_regconesup = $request->ad_regconesup;
            $res->fecha_reg_conesup = $request->fecha_reg_conesup;
            $res->sub_area_conocimiento = $request->sub_area_conocimiento;
            $res->ad_estado = $request->ad_estado;
            $res->ultima_actualizacion = $request->ultima_actualizacion;
            $res->nv_id = $request->nv_id;
            $res->ad_archivo = $request->ad_archivo;
            $res->cod_ies = $request->cod_ies;
            if ($res->save()) {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "Actualizado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => "Error al Actualizar",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "Academico Docente con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = AcademicoDocente::find($id);
        if (isset($res)) {
            $elim = AcademicoDocente::destroy($id);
            if ($elim) {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "Eliminado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "Academico Docente no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "Academico Docente con id: $id no Existe",
            ]);
        }
    }
    public function uploadTitulo(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // 10MB
            'ci'   => 'required'
        ]);

        try {
            $file = $request->file('file');
            $ci   = $request->ci;

            // Crear carpeta si no existe
            $directory = public_path('titulos_universitarios_CVN/' . $ci);

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            // Generar nombre: CI + _ + aleatorio + _ + fecha (Ymd_His)
            $aleatorio = bin2hex(random_bytes(8)); // 16 caracteres hex
            $fechaHora = date("Ymd_His");          // Ej: 20251112_1741
            $extension = $file->getClientOriginalExtension(); // pdf

            $filename = "{$ci}_{$aleatorio}_{$fechaHora}.{$extension}";

            // Guardar archivo
            $file->move($directory, $filename);

            // URL pública
            $url = url('titulos_universitarios_CVN/' . $ci . '/' . $filename);

            return response()->json([
                'status'   => true,
                'filename' => $filename,
                'url'      => $url
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Error guardando archivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function uploadTituloposgrado(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // 10MB
            'ci'   => 'required'
        ]);

        try {
            $file = $request->file('file');
            $ci   = $request->ci;

            // Crear carpeta si no existe
            $directory = public_path('titulos_posgrado_CVN/' . $ci);

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            // Generar nombre: CI + _ + aleatorio + _ + fecha (Ymd_His)
            $aleatorio = bin2hex(random_bytes(8)); // 16 caracteres hex
            $fechaHora = date("Ymd_His");          // Ej: 20251112_1741
            $extension = $file->getClientOriginalExtension(); // pdf

            $filename = "{$ci}_{$aleatorio}_{$fechaHora}.{$extension}";

            // Guardar archivo
            $file->move($directory, $filename);

            // URL pública
            $url = url('titulos_posgrado_CVN/' . $ci . '/' . $filename);

            return response()->json([
                'status'   => true,
                'filename' => $filename,
                'url'      => $url
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Error guardando archivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
