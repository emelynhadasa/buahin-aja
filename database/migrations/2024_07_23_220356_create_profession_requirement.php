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
        Schema::create('profession_requirements', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('profession_id')->constrained('professions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
