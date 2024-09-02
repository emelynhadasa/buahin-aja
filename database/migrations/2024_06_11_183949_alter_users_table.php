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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("name");
            $table->string("first_name");
            $table->string("last_name");
            $table->unsignedBigInteger("student_id")->unique();
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('avatar_id')->constrained('avatars')->onDelete('cascade');
            $table->date("date_of_birth");
            $table->decimal("gpa", 3, 2)->default("0.00");


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
