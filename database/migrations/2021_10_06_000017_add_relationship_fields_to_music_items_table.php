<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMusicItemsTable extends Migration
{
    public function up()
    {
        Schema::table('music_items', function (Blueprint $table) {
            $table->unsignedBigInteger('playlist_id');
            $table->foreign('playlist_id', 'playlist_fk_5051383')->references('id')->on('playlists');
        });
    }
}
