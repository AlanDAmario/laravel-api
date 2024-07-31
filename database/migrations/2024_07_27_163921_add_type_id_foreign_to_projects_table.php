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
        Schema::table('projects', function (Blueprint $table) {

            //creazione campo
            $table->unsignedBigInteger('type_id')->nullable()->after('id');

            //aggiunta chiave esterna foreign key
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->nullOnDelete();

            //modalità abbreviata, della creazione campo e foreign key
            //$table->foreign('type_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            //rimozione chiave esterna
            $table->dropForeign('projects_type_id_foreign');

            //rimozione campo
            $table->dropColumn('type_id');
        });
    }
};
