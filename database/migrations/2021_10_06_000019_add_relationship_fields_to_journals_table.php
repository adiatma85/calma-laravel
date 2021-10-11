<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToJournalsTable extends Migration
{
    public function up()
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->unsignedBigInteger('journey_id')->nullable();
            $table->foreign('journey_id', 'journey_fk_5052422')->references('id')->on('journeys');
        });
    }
}
