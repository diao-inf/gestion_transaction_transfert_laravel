<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function transactionsEnvois()
    {
        return $this->hasMany(Transaction::class, 'compte_source_id');
    }

    public function transactionsRecus()
    {
        return $this->hasMany(Transaction::class, 'compte_destinataire_id');
    }
}
