<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUnusedSentinelPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Before dropping columns from a SQLite database, 
        // you will need to run the below compose command 
        // to add the add doctrine/dbal package
        //   composer require doctrine/dbal "*"

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('permissions');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('permissions')->nullable();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->text('permissions')->nullable();
        });
    }
}
