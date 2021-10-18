<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInUserJournalAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_journal_answers', function (Blueprint $table) {
            $table->string('answer')->nullable()->after('id');
            $table->unsignedBigInteger('journey_id')->nullable()->after('answer');

            $table->foreign('journey_id', 'user_journal_answer_to_user_fk_1')->references('id')->on('journeys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_journal_answers', function (Blueprint $table) {
            $table->dropForeign('user_journal_answer_to_user_fk_1');

            $table->dropColumn('journey_id');
            $table->dropColumn('answer');
        });
    }
}
