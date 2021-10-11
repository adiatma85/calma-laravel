<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodTrackersTable extends Migration
{
    public function up()
    {
        Schema::create('mood_trackers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mood');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
