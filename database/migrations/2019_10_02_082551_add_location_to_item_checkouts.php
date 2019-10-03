<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToItemCheckouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_checkouts', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')
                ->nullable();
            $table->foreign('location_id')
                ->references('id')
                ->on('item_types');

            $table->unsignedBigInteger('user_id')
                ->nullable()->change();

            $table->dateTime('due_date')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_checkouts', function (Blueprint $table) {

        });
    }
}
