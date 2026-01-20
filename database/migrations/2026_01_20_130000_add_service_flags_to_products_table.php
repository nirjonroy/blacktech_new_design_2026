<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'products';

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (! Schema::hasColumn($tableName, 'is_main_service')) {
                $table->boolean('is_main_service')->default(0);
            }
            if (! Schema::hasColumn($tableName, 'serial')) {
                $table->integer('serial')->nullable()->after('is_main_service');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = 'products';

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (Schema::hasColumn($tableName, 'serial')) {
                $table->dropColumn('serial');
            }
            if (Schema::hasColumn($tableName, 'is_main_service')) {
                $table->dropColumn('is_main_service');
            }
        });
    }
};
