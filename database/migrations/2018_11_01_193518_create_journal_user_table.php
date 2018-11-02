<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_user', function (Blueprint $table) {
            $table->unsignedInteger('journal_id');
            $table->foreign('journal_id')->references('id')->on('journals');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('next_user_id')->nullable();
            $table->foreign('next_user_id')->references('id')->on('users');

            $table->primary(['journal_id', 'user_id']);
            $table->unique(['journal_id', 'next_user_id']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_user');
    }
}
