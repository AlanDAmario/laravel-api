<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //*****************************TABELLA PIVOT*********************************** */
    //La tabella project_technology è una tabella pivot che collega i progetti e le tecnologie in una relazione molti-a-molti. Essa memorizza quali tecnologie sono associate a quali progetti.
    //Le chiavi esterne garantiscono l'integrità referenziale, e le combinazioni uniche assicurano che ogni associazione sia unica. I timestamp forniscono informazioni su quando i record sono stati creati o modificati.
    public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();

            //foreign project
            // foreignId('project_id'): Aggiunge una colonna chiamata project_id che memorizza l'ID del progetto.

            // constrained(): Indica che questa colonna è una chiave esterna che fa riferimento alla colonna id della tabella projects.

            // cascadeOnDelete(): Se un progetto viene eliminato dalla tabella projects, anche le righe corrispondenti nella tabella project_technology verranno eliminate automaticamente.

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();


            //foreign technology
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();


            //chiave unica
            $table->unique(['project_id', 'technology_id']);


            //timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
