<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurhatanIdFieldInCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('curhatan_id')->nullable();
            $table->foreign('curhatan_id', "comment_curhat_relation_fk_1")->references('id')->on('curhatans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('comment_curhat_relation_fk_1');
            $table->dropColumn('curhatan_id');
        });
    }
}
