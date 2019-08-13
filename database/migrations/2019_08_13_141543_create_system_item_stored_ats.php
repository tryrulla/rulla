<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rulla\Items\Types\TypeStoredAt;

class CreateSystemItemStoredAts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TypeStoredAt::create([
            'id' => 1,
            'stored_type_id' => 1,  // TYPE
            'storage_type_id' => 2, // LOCATION
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        TypeStoredAt::destroy(1);
    }
}
