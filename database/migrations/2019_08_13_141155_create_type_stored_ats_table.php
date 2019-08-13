<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeStoredAtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_stored_ats', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('stored_type_id')
                ->nullable();
            $table->foreign('stored_type_id')
                ->references('id')
                ->on('item_types');

            $table->unsignedBigInteger('storage_type_id')
                ->nullable();
            $table->foreign('storage_type_id')
                ->references('id')
                ->on('item_types');

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
        Schema::dropIfExists('type_stored_ats');
    }
}
