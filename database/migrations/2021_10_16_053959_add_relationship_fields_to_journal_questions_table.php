<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToJournalQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_id')->nullable()->after('question');
            $table->foreign('journal_id', 'journal_questions_fk_journal_id_1')->references('id')->on('journals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_questions', function (Blueprint $table) {
            $table->dropForeign('journal_id', 'journal_questions_fk_journal_id_1');
            $table->dropColumn('journal_id');
        });
    }
}
