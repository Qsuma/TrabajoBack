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
        Schema::create('llegada__doc11s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->enum('doc1',['Cert. di nascita', 'Procura']);
            $table->enum('doc2',['Stato libero', 'Sentenza di divorzio','Atto di morte']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llegada__doc11s');
    }
};
