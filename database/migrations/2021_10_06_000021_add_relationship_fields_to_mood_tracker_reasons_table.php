<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMoodTrackerReasonsTable extends Migration
{
    public function up()
    {
        Schema::table('mood_tracker_reasons', function (Blueprint $table) {
            $table->unsignedBigInteger('mood_tracker_id')->nullable();
            $table->foreign('mood_tracker_id', 'mood_tracker_fk_5052368')->references('id')->on('mood_trackers');
        });
    }
}
