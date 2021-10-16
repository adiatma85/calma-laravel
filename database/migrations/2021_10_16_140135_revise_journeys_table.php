<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviseJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journeys', function (Blueprint $table) {
            // Remove Foreign
            $table->dropForeign('user_fk_5052407');
            $table->dropForeign('mood_tracker_fk_5052408');
            $table->dropForeign('playlist_fk_5052409');
            // Remove the column fields
            $table->dropColumn('user_id');
            $table->dropColumn('mood_tracker_id');
            $table->dropColumn('playlist_id');
            // Add
            $table->string('title')->nullable()->after('id');
            $table->string('author')->nullable()->after('title');
            $table->text('description')->nullable()->after('author');
            $table->unsignedSmallInteger('urutan')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journeys', function (Blueprint $table) {

            // Revive the foreign key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5052407')->references('id')->on('users');
            $table->unsignedBigInteger('mood_tracker_id')->nullable();
            $table->foreign('mood_tracker_id', 'mood_tracker_fk_5052408')->references('id')->on('mood_trackers');
            $table->unsignedBigInteger('playlist_id')->nullable();
            $table->foreign('playlist_id', 'playlist_fk_5052409')->references('id')->on('playlists');

            // Remove the column
            $table->dropColumn('title');
            $table->dropColumn('author');
            $table->dropColumn('description');
            $table->dropColumn('urutan');
        });
    }
}
