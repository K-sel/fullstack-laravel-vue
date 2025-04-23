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
        Schema::table('users', function (Blueprint $table) {
            // Ajouter les nouveaux champs
            $table->string('firstname');
            $table->text('lastname');
            
            // Supprimer le champ name
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recréer le champ supprimé en cas de rollback
            $table->string('name');
            
            // Supprimer les nouveaux champs ajoutés
            $table->dropColumn(['firstname', 'lastname']);
        });
    }
};