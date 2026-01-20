<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'footer_contact_note')) {
                $table->text('footer_contact_note')->nullable()->after('footer_google_location');
            }
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'footer_contact_note')) {
                $table->dropColumn('footer_contact_note');
            }
        });
    }
};
