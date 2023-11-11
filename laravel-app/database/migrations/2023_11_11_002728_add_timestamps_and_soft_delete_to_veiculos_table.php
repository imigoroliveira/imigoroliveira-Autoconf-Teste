<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->timestamps(); // Adiciona as colunas created_at e updated_at
            $table->softDeletes(); // Adiciona a coluna deleted_at para soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Remove a coluna deleted_at
        });
    }
};
