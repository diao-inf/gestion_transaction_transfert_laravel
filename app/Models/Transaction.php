<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function compteEnvoi()
    {
        return $this->belongsTo(Compte::class, 'compte_source_id');
    }

    public function compteRecu()
    {
        return $this->belongsTo(Compte::class, 'compte_destinataire_id');
    }
}
