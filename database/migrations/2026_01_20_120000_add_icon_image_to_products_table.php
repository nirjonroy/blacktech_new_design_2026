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
            if (! Schema::hasColumn($tableName, 'icon_image')) {
                if (Schema::hasColumn($tableName, 'thumb_image')) {
                    $table->string('icon_image')->nullable()->after('thumb_image');
                } else {
                    $table->string('icon_image')->nullable();
                }
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
            if (Schema::hasColumn($tableName, 'icon_image')) {
                $table->dropColumn('icon_image');
            }
        });
    }
};
