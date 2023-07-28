<?php

namespace App\Http\Controllers;

use App\Models\{Transaction,
    Compte,
    Client
};
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function depot(Request $request)
    {
        $compte_id = $request->input('compte_id');
        $montant = $request->input('montant');
        $frais = 0;

        $compte = Compte::find($compte_id);
        if (!$compte) {
            return response()->json(['statut'=>Response::HTTP_NOT_FOUND,'message' => 'Compte introuvable'],404);
        }

        if($compte->fournisseur == 'ORANGE MONEY' || $compte->fournisseur == 'WAVE'){
            $frais = ($montant*1)%100;
        }else if($compte->fournisseur == 'WARI'){
            $frais = ($montant*2)%100;
        }else{
            $frais = ($montant*5)%100;
        }

        $compte->solde += ($montant-$frais);
        $compte->save();

        $transaction = new Transaction();
        $transaction->type = 'DEPOT';
        $transaction->montant = $montant;
        $transaction->compte_source_id = $compte_id;
        $transaction->compte_destinataire_id = $compte_id;
        $transaction->frais = $frais;
        $transaction->save();

        return response()->json(['statut'=>Response::HTTP_OK,'message' => 'Dépôt effectué avec succès']);
    }

    public function retrait(Request $request)
    {
        $compte_id = $request->input('compte_id');
        $montant = $request->input('montant');
        $frais = 0;

        $compte = Compte::find($compte_id);
        if (!$compte) {
            return response()->json(['statut'=>Response::HTTP_NOT_FOUND,'message' => 'Compte introuvable'], 404);
        }

        if ($compte->solde < $montant) {
            return response()->json(['statut'=>Response::HTTP_BAD_REQUEST,'message' => 'Solde insuffisant'], 400);
        }
        if($compte->fournisseur == 'ORANGE MONEY' || $compte->fournisseur == 'WAVE'){
            $frais = ($montant*1)%100;
        }else if($compte->fournisseur == 'WARI'){
            $frais = ($montant*2)%100;
        }else{
            $frais = ($montant*5)%100;
        }

        $compte->solde -= ($montant+$frais);
        $compte->save();

        $transaction = new Transaction();
        $transaction->type = 'RETRAIT';
        $transaction->montant = $montant;
        $transaction->compte_source_id = $compte_id;
        $transaction->compte_destinataire_id = $compte_id;
        $transaction->frais = $frais;
        $transaction->save();

        return response()->json(['statut'=>Response::HTTP_OK,'message' => 'Retrait effectué avec succès']);
    }

    public function transfert(Request $request)
    {
        $compte_source_id = $request->input('compte_source_id');
        $compte_destinataire_id = $request->input('compte_destinataire_id');
        $montant = $request->input('montant');
        $frais = 0;

        $compte_source = Compte::find($compte_source_id);
        $compte_destinataire = Compte::find($compte_destinataire_id);
        if (!$compte_source || !$compte_destinataire) {
            return response()->json(['statut'=>Response::HTTP_NOT_FOUND, 'message' => 'Compte source ou compte destinataire introuvable'], 404);
        }

        if ($compte_source->solde < $montant) {
            return response()->json(['statut'=>Response::HTTP_BAD_REQUEST,'message' => 'Solde insuffisant'], 400);
        }

        if($compte_source->fournisseur !== $compte_destinataire->fournisseur) {
            return response()->json(['statut'=>Response::HTTP_BAD_REQUEST,'message' => 'Operateur different'], 400);
        }

        if($compte_source->fournisseur == 'ORANGE MONEY' || $compte_source->fournisseur == 'WAVE'){
            $frais = ($montant*1)%100;
        }else if($compte_source->fournisseur == 'WARI'){
            $frais = ($montant*2)%100;
        }else{
            $frais = ($montant*5)%100;
        }

        $compte_source->solde -= ($montant+$frais);
        $compte_source->save();

        $compte_destinataire->solde += ($montant-$frais);
        $compte_destinataire->save();

        $transaction = new Transaction();
        $transaction->type = 'TRANSFERT';
        $transaction->montant = $montant;
        $transaction->compte_source_id = $compte_source_id;
        $transaction->compte_destinataire_id = $compte_destinataire_id;
        $transaction->frais = $frais;
        $transaction->save();

        return response()->json(['statut'=>Response::HTTP_OK,'message' => 'Transfert effectué avec succès']);
    }
}
