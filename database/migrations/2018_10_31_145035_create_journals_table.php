<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('period');
            $table->timestamp('next_change');

            $table->unsignedInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');

            $table->unsignedInteger('current_user_id');
            $table->foreign('current_user_id')->references('id')->on('users');

            $table->boolean('active')->nullable()->default('true');

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
        Schema::dropIfExists('journals');
    }
}
