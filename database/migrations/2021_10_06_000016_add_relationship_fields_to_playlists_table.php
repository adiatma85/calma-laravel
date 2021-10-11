<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPlaylistsTable extends Migration
{
    public function up()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id', 'topic_fk_5051384')->references('id')->on('music_topics');
        });
    }
}
