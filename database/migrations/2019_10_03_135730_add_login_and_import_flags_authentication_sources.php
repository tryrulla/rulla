<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rulla\Authentication\Models\AuthenticationSource;

class AddLoginAndImportFlagsAuthenticationSources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authentication_sources', function (Blueprint $table) {
            $table->boolean('use_login')
                ->default(false);
            $table->boolean('use_import')
                ->default(false);
        });

        AuthenticationSource::query()
            ->update([
                'use_login' => true,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authentication_sources', function (Blueprint $table) {
            $table->dropColumn('use_login');
            $table->dropColumn('use_import');
        });
    }
}
