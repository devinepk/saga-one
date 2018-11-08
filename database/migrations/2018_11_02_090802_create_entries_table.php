<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 512)->nullable()->default('[Untitled]');
            $table->text('body')->nullable();

            $table->unsignedInteger('journal_id');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

            $table->unsignedInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['draft', 'final']);

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
        Schema::dropIfExists('entries');
    }
}
