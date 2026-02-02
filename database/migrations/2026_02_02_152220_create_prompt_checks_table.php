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
        Schema::create('prompt_checks', function (Blueprint $table) {
            $table->id();
            $table->longText('prompt');
            $table->string('purpose')->nullable();
            $table->string('sensitivity')->default('internal'); // public|internal|confidential|pii
            $table->string('result')->default('pass'); // pass|warn|block
            $table->unsignedSmallInteger('score')->default(0); // 0-100
            $table->json('reasons')->nullable(); // ["pii_email","secret_like","jailbreak"]
            $table->json('meta')->nullable();    // extra info (matches, counts, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_checks');
    }
};
