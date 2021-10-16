<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviseJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journals', function (Blueprint $table) {
            // Drop Content
            $table->dropColumn('content');
            // Drop category
            $table->dropColumn('category');
            // Drop Journey id
            $table->dropForeign('journey_fk_5052422');
            $table->dropColumn('journey_id');
            // Insert new column
            $table->string('name')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journals', function (Blueprint $table) {
            // Rollback content
            $table->longText('content')->nullable()->after('id');
            // Rollback category
            $table->string('category')->nullable()->after('content');
            // Rollback Journey id
            $table->unsignedBigInteger('journey_id')->nullable()->after('category');
            $table->foreign('journey_id', 'journey_fk_5052422')->references('id')->on('journeys');
            // Drop name column
            $table->dropColumn('name');
        });
    }
}
