<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropNameFromInvites extends Migration
{
    /**
     * Drop the NAME column from the Invites table
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invites', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Restore the NAME column to the Invites table
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invites', function (Blueprint $table) {
            $table->string('name');
        });
    }
}
