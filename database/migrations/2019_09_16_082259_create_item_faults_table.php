<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_faults', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items');

            $table->unsignedBigInteger('assignee_id')
                ->nullable();
            $table->foreign('assignee_id')
                ->references('id')
                ->on('users');

            $table->string('title');
            $table->text('description')
                ->nullable();

            $table->boolean('closed')
                ->default(false);

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
        Schema::dropIfExists('item_faults');
    }
}
