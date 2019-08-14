<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('parent_id')
                ->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('item_types');

            $table->string('name');

            $table->boolean('system')
                ->default(false);

            $table->softDeletes();
            $table->timestamps();
        });

        DB::update("ALTER TABLE item_types AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_types');
    }
}
