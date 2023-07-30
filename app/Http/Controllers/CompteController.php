<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $comptes = Compte::all();
            if ($comptes->isEmpty()) {
                return response()->json(['statut'=>Response::HTTP_NOT_FOUND,'message' => 'Aucun compte trouvé.'], 404);
            }
            return response()->json(['statut'=>Response::HTTP_OK,'data' => $comptes], 200);
        } catch (\Exception $e) {
            return response()->json(['statut'=>Response::HTTP_BAD_REQUEST,'message' => 'Une erreur s\'est produite lors de la récupération des comptes.'], 500);
        }
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
    public function show(Compte $compte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compte $compte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compte $compte)
    {
        //
    }
}
