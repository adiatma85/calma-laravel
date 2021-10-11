<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMoodTrackersTable extends Migration
{
    public function up()
    {
        Schema::table('mood_trackers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5052276')->references('id')->on('users');
        });
    }
}
