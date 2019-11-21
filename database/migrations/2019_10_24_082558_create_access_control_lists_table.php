<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessControlListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_control_lists', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('priority')
                ->default(0);

            $table->boolean('system')
                ->default(false);
            $table->json('data');

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
        Schema::dropIfExists('access_control_lists');
    }
}
