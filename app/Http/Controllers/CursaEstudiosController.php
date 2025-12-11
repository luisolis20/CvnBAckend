<?php

namespace App\Http\Controllers;

use App\Models\CursaEstudios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CursaEstudiosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = CursaEstudios::select(
                'cursa_estudios.*',
                'informacionpersonal_d.ApellInfPer',
                'informacionpersonal_d.ApellMatInfPer',
                'informacionpersonal_d.NombInfPer',
                'inst_educ_sup.*',
                'pais.*',
                'nivel.*',
                'periodolectivo.*',
                'subarea_unesco.*',
            )
                ->join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'cursa_estudios.ciinfper')
                ->join('inst_educ_sup', 'inst_educ_sup.cod_ies', '=', 'cursa_estudios.ec_institucion')
                ->join('pais', 'pais.cod_pais', '=', 'cursa_estudios.ec_pais')
                ->join('nivel', 'nivel.nv_id', '=', 'cursa_estudios.nv_id')
                ->join('periodolectivo', 'periodolectivo.idper', '=', 'cursa_estudios.idper')
                ->join('subarea_unesco', 'subarea_unesco.sau_id', '=', 'cursa_estudios.ec_sub_area_conocimiento');
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


        $res = CursaEstudios::create($inputs);
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
        $data = CursaEstudios::select(
            'cursa_estudios.*',
            'informacionpersonal_d.ApellInfPer',
            'informacionpersonal_d.ApellMatInfPer',
            'informacionpersonal_d.NombInfPer',
            'inst_educ_sup.*',
            'pais.*',
            'nivel.*',
            'subarea_unesco.*',
        )
            ->join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'cursa_estudios.ciinfper')
            ->join('inst_educ_sup', 'inst_educ_sup.cod_ies', '=', 'cursa_estudios.ec_institucion')
            ->join('pais', 'pais.cod_pais', '=', 'cursa_estudios.ec_pais')
            ->join('nivel', 'nivel.nv_id', '=', 'cursa_estudios.nv_id')
            ->join('subarea_unesco', 'subarea_unesco.sau_id', '=', 'cursa_estudios.ec_sub_area_conocimiento')
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
    public function showposgrado(string $id)
    {
        $data = CursaEstudios::select(
            'cursa_estudios.*',
            'informacionpersonal_d.ApellInfPer',
            'informacionpersonal_d.ApellMatInfPer',
            'informacionpersonal_d.NombInfPer',
            'inst_educ_sup.*',
            'pais.*',
            'nivel.*',
            'subarea_unesco.*',
        )
            ->join('informacionpersonal_d', 'informacionpersonal_d.CIInfPer', '=', 'cursa_estudios.ciinfper')
            ->join('inst_educ_sup', 'inst_educ_sup.cod_ies', '=', 'cursa_estudios.ec_institucion')
            ->join('pais', 'pais.cod_pais', '=', 'cursa_estudios.ec_pais')
            ->join('nivel', 'nivel.nv_id', '=', 'cursa_estudios.nv_id')
            ->join('subarea_unesco', 'subarea_unesco.sau_id', '=', 'cursa_estudios.ec_sub_area_conocimiento')
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
        $res = CursaEstudios::find($id);
        if (isset($res)) {
            $res->ciinfper = $request->ciinfper;
            $res->idper = $request->idper;
            $res->ec_numdoc = $request->ec_numdoc;
            $res->ec_titulo = $request->ec_titulo;
            $res->ec_institucion = $request->ec_institucion;
            $res->ec_pais = $request->ec_pais;
            $res->ec_fecha_inicia = $request->ec_fecha_inicia;
            $res->ec_fecha_termina = $request->ec_fecha_termina;
            $res->ec_sub_area_conocimiento = $request->ec_sub_area_conocimiento;
            $res->ec_estado = $request->ec_estado;
            $res->ultima_actualizacion = $request->ultima_actualizacion;
            $res->nv_id = $request->nv_id;
            $res->ec_archivo = $request->ec_archivo;
            $res->ec_inst_financia = $request->ec_inst_financia;
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
                'mensaje' => "Cursa Estudios con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = CursaEstudios::find($id);
        if (isset($res)) {
            $elim = CursaEstudios::destroy($id);
            if ($elim) {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "Eliminado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "Cursa Estudios no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "Cursa Estudios con id: $id no Existe",
            ]);
        }
    }
    public function uploadCursaEstudios(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // 10MB
            'ci'   => 'required'
        ]);

        try {
            $file = $request->file('file');
            $ci   = $request->ci;

            // Crear carpeta si no existe
            $directory = public_path('cursa_estudios_CVN/' . $ci);

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
            $url = url('cursa_estudios_CVN/' . $ci . '/' . $filename);

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
    public function uploadCursaEstudiosPosgrado(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // 10MB
            'ci'   => 'required'
        ]);

        try {
            $file = $request->file('file');
            $ci   = $request->ci;

            // Crear carpeta si no existe
            $directory = public_path('cursa_posgrado_CVN/' . $ci);

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
            $url = url('cursa_posgrado_CVN/' . $ci . '/' . $filename);

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
