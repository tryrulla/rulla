<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rulla\Items\Types\ItemType;

class CreateSystemItemTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ItemType::create([
            'id' => 1,
            'name' => 'Item Type',
            'system' => true,
        ]);

        ItemType::create([
            'id' => 2,
            'name' => 'Location',
            'system' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ItemType::findMany([1, 2])->each(function ($it) {
            $it->forceDelete();
        });
    }
}
