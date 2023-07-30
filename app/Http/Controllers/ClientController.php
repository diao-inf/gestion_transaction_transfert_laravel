<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clients = Client::with("comptes")->get();
            // $clients = Client::all();
            if ($clients->isEmpty()) {
                return response()->json(['statut'=>Response::HTTP_NOT_FOUND,'message' => 'Aucun client trouvé.'], 404);
            }
            return response()->json(['statut'=>Response::HTTP_OK,'data' => $clients], 200);
        } catch (\Exception $e) {
            return response()->json(['statut'=>Response::HTTP_BAD_REQUEST,'message' => 'Une erreur s\'est produite lors de la récupération des clients.'], 500);
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }

    public function getTransactions($id)
    {
        try {
            $client = Client::findOrFail($id);
            $transactions = $client->comptes->flatMap->transactionsEnvois;
            return response()->json(['statut'=>Response::HTTP_OK,'data' => $transactions], 200);
        } catch (Exception $e) {
            return response()->json(['statut'=>Response::HTTP_NOT_FOUND,'data' => null], 400);
        }
    }
}
