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
        Schema::create('session_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_exercise_id')->constrained('session_exercises')->onDelete('cascade');
            $table->decimal('weight', 8, 2);
            $table->integer('reps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_sets');
    }
};
