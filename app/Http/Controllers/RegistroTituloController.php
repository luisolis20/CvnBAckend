<?php

namespace App\Http\Controllers;

use App\Models\RegistroTitulos;
use Illuminate\Http\Request;

class RegistroTituloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RegistroTitulos::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = RegistroTitulos::select(
            'registrotitulos.*',
            'carrera.*',
        )
            ->join('carrera', 'carrera.idCarr', '=', 'registrotitulos.idcarr')
            ->where('registrotitulos.ciinfper', $id)
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron interacciones para este emprendimiento'], 404);
        }

        $data->transform(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (is_string($value)) {
                    $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $item;
        });

        // Si el usuario tiene más de un título
        if ($data->count() > 1) {
            $carreras = $data->map(function ($titulo) {
                return [
                    'idCarr' => $titulo->idCarr,
                    'NombCarr' => $titulo->NombCarr
                ];
            })->unique('idCarr')->values();

            return response()->json([
                'multiple' => true,
                'carreras' => $carreras,
                'titulos' => $data
            ]);
        }

        // Si solo tiene un título
        $titulo = $data->first();

        return response()->json([
            'multiple' => false,
            'titulo' => $titulo
        ]);
    }
    public function titulog(string $id)
    {
        $data = RegistroTitulos::select(
            'registrotitulos.*',
            'carrera.*'
        )
            ->join('carrera', 'carrera.idCarr', '=', 'registrotitulos.idcarr')
            ->where('registrotitulos.ciinfper', $id)
            ->where('carrera.idfacultad', '!=', 6)
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron títulos registrados para este estudiante'], 404);
        }

        // Normalizamos los valores en UTF-8
        $data->transform(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (is_string($value)) {
                    $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $item;
        });

        if ($data->count() > 1) {
            $carreras = $data->map(function ($titulo) {
                return [
                    'idCarr' => $titulo->idCarr,
                    'tituloh' => $titulo->tituloh,
                    'titulom' => $titulo->titulom,
                ];
            })->unique('idCarr')->values();

            return response()->json([
                'multiple' => true,
                'carreras' => $carreras,
                'titulos' => $data
            ]);
        }

        // Solo un título
        $titulo = $data->first();

        return response()->json([
            'multiple' => false,
            'titulo' => $titulo
        ]);
    }
    public function titulogPosgrados(string $id)
    {
        $data = RegistroTitulos::select(
            'registrotitulos.*',
            'carrera.*'
        )
            ->join('carrera', 'carrera.idCarr', '=', 'registrotitulos.idcarr')
            ->where('registrotitulos.ciinfper', $id)
            ->where('carrera.idfacultad', 6)
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron títulos registrados para este estudiante'], 404);
        }

        // Normalizamos los valores en UTF-8
        $data->transform(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (is_string($value)) {
                    $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $item;
        });

        if ($data->count() > 1) {
            $carreras = $data->map(function ($titulo) {
                return [
                    'idCarr' => $titulo->idCarr,
                    'tituloh' => $titulo->tituloh,
                    'titulom' => $titulo->titulom,
                ];
            })->unique('idCarr')->values();

            return response()->json([
                'multiple' => true,
                'carreras' => $carreras,
                'titulos' => $data
            ]);
        }

        // Solo un título
        $titulo = $data->first();

        return response()->json([
            'multiple' => false,
            'titulo' => $titulo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
