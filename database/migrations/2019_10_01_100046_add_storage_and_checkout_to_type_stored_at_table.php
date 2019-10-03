<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rulla\Items\Types\TypeStoredAt;

class AddStorageAndCheckoutToTypeStoredAtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_stored_ats', function (Blueprint $table) {
            $table->boolean('storage')
                ->default(false);
            $table->boolean('checkout')
                ->default(false);
        });

        TypeStoredAt::query()
            ->update([
                'storage' => true,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_stored_ats', function (Blueprint $table) {
            $table->dropColumn('storage');
            $table->dropColumn('checkout');
        });
    }
}
