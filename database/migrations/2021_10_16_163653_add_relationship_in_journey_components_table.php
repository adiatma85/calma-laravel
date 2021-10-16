<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipInJourneyComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journey_components', function (Blueprint $table) {
            $table->unsignedBigInteger('journey_id')->nullable();
            $table->foreign('journey_id', 'journeys_fk_1')->references('id')->on('journeys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journey_components', function (Blueprint $table) {
            $table->dropForeign('journeys_fk_1');
            $table->dropColumn('journey_id');
        });
    }
}
