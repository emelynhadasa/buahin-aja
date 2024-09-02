<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescToSubmissionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submission_events', function (Blueprint $table) {
            $table->text('desc')->nullable()->after('file_size'); // Replace 'existing_column_name' with the column after which you want to add 'desc'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submission_events', function (Blueprint $table) {
            $table->dropColumn('desc');
        });
    }
}
