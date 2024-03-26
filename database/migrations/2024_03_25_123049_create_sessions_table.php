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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->decimal('weight', 6, 3);
            $table->decimal('height', 3, 2);
            $table->decimal('chest_measurement', 5, 2);
            $table->decimal('waist_measurement', 5, 2);
            $table->decimal('hips_measurement', 5, 2);
            $table->integer('distance_run');
            $table->enum('status', ['NOT FINISHED', 'FINISHED']);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
