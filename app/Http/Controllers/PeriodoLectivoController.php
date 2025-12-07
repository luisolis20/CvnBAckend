<?php

namespace App\Http\Controllers;

use App\Models\PeriodoLectivo;
use Illuminate\Http\Request;

class PeriodoLectivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getActivos()
    {
        $periodos = PeriodoLectivo::where('StatusPerLec', 1)
            ->select('idper', 'DescPerLec')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $periodos
        ]);
    }
}
