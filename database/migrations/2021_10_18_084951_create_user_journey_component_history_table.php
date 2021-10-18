<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJourneyComponentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_journey_component_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('journey_id')->nullable();
            $table->unsignedBigInteger('journey_component_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            // NO FOREIGN KEY!
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_journey_component_history');
    }
}
