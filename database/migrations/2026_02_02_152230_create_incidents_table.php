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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('policy'); // pii|secrets|jailbreak|policy|other
            $table->string('severity')->default('low');    // low|medium|high|critical
            $table->string('status')->default('open');     // open|investigating|resolved|closed
            $table->longText('prompt_snapshot');
            $table->foreignId('prompt_check_id')->nullable()->constrained()->nullOnDelete();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
