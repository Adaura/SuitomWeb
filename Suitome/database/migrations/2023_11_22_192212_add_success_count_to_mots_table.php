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
        Schema::table('mots', function (Blueprint $table) {
            // Ajouter la colonne success_count à la table mots
            $table->integer('success_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mots', function (Blueprint $table) {
            // Supprimer la colonne success_count si la migration est annulée
            $table->dropColumn('success_count');
        });
    }
};
