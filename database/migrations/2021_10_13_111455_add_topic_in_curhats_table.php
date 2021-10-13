<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTopicInCurhatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curhats', function (Blueprint $table) {
            $table->string('tittle')->nullable()->after('id');
            $table->string('topic')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curhats', function (Blueprint $table) {
            $table->dropColumn('tittle');
            $table->dropColumn('topic');
        });
    }
}
