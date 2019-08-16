<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldAppliesTosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_applies_tos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
                ->onDelete('cascade');

            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('item_types');

            $table->boolean('apply_to_type')
                ->default(false);
            $table->boolean('apply_to_item')
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
        Schema::dropIfExists('field_applies_tos');
    }
}
