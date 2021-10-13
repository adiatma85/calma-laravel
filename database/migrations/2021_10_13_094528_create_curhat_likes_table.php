<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurhatLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curhat_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_id_fk_curhat_like_1')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('curhatan_id')->nullable();
            $table->foreign('curhatan_id', 'curhatan_id_fk_curhat_like_2')->references('id')->on('curhatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curhat_likes');
    }
}
