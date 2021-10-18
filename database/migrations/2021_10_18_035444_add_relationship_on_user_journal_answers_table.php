<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipOnUserJournalAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('journey_components', function (Blueprint $table) {
        //     $table->unsignedBigInteger('journey_id')->nullable();
        //     $table->foreign('journey_id', 'journeys_fk_1')->references('id')->on('journeys');
        // });
        Schema::table('user_journal_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unsignedBigInteger('journal_question_id')->nullable()->after('user_id');

            $table->foreign('user_id', 'user_journal_answer_fk_users_1')->references('id')->on('users');
            $table->foreign('journal_question_id', 'user_journal_answer_fk_jouranls_1')->references('id')->on('journal_questions');
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
            $table->dropForeign('user_journal_answer_fk_users_1');
            $table->dropForeign('user_journal_answer_fk_jouranls_1');

            $table->dropColumn('user_id');
            $table->dropColumn('journal_question_id');
        });
    }
}
