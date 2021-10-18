<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviveMoodInMoodTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mood_trackers', function (Blueprint $table) {
            // Made to double
            $table->double('mood', 8, 2)->default(0)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mood_trackers', function (Blueprint $table) {
            $table->dropColumn('mood');
        });
    }
}
