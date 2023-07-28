<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['DEPOT', 'RETRAIT', 'TRANSFERT']);
            $table->float('montant');
            $table->float('frais');
            $table->boolean('is_immediate')->default(false);
            $table->string('code')->nullable();
            $table->foreignId('compte_source_id')->constrained('comptes');
            $table->foreignId('compte_destinataire_id')->constrained('comptes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
