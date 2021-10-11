<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToJourneysTable extends Migration
{
    public function up()
    {
        Schema::table('journeys', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5052407')->references('id')->on('users');
            $table->unsignedBigInteger('mood_tracker_id')->nullable();
            $table->foreign('mood_tracker_id', 'mood_tracker_fk_5052408')->references('id')->on('mood_trackers');
            $table->unsignedBigInteger('playlist_id')->nullable();
            $table->foreign('playlist_id', 'playlist_fk_5052409')->references('id')->on('playlists');
        });
    }
}
