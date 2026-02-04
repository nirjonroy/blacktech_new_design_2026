<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('biography');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_image')->nullable()->after('meta_description');
            $table->string('author')->nullable()->after('meta_image');
            $table->string('publisher')->nullable()->after('author');
            $table->string('copyright')->nullable()->after('publisher');
            $table->string('keywords')->nullable()->after('copyright');
        });
    }

    public function down()
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_image',
                'author',
                'publisher',
                'copyright',
                'keywords',
            ]);
        });
    }
};
