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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('original_word', 150)->nullable(false);
            $table->string('original_index', 150)->nullable(false);
            $table->string('translate_word', 150)->nullable(false);
            $table->string('translate_index', 150)->nullable(false);
            $table->string('think_orig_lang', 150)->nullable(false);
            $table->string('think_tran_lang', 150)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
