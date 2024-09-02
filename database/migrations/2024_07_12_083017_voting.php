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

        Schema::create('voting', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('image_url');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('voting_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_id')->constrained('voting')->onDelete('cascade');
            $table->text('text');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('voting_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_id')->constrained('voting')->onDelete('cascade');
            $table->foreignId('voting_option_id')->constrained('voting_options')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->unique(['voting_id', 'student_id']);
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
