<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->timestamps();
            $table->uuid('uid')->primary();
            $table->uuid('usuarioUid');
            $table->foreign('usuarioUid')
                ->references('uid')
                ->on('usuarios');
            $table->text('input');
            $table->text('sanitizedInput');
            $table->text('results')->nullable();
            $table->boolean('isSafe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
