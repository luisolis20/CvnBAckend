<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RevistaCientifica;

class RevistaCientificaDocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RevistaCientifica::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return RevistaCientifica::select('revistas_cientificas.*')
        ->where('revistas_cientificas.CIInfPer', $id)
        ->get();
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
    public function destroy(string $id)
    {
        //
    }
}
