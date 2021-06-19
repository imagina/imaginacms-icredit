<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcreditCreditTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icredit__credit_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('description');
            // Your translatable fields

            $table->integer('credit_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['credit_id', 'locale']);
            $table->foreign('credit_id')->references('id')->on('icredit__credits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icredit__credit_translations', function (Blueprint $table) {
            $table->dropForeign(['credit_id']);
        });
        Schema::dropIfExists('icredit__credit_translations');
    }
}
