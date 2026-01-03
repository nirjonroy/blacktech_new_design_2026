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
        Schema::table('seo_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('seo_settings', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('seo_description');
            }

            if (!Schema::hasColumn('seo_settings', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }

            if (!Schema::hasColumn('seo_settings', 'meta_image')) {
                $table->string('meta_image')->nullable()->after('meta_description');
            }

            if (!Schema::hasColumn('seo_settings', 'author')) {
                $table->string('author')->nullable()->after('meta_image');
            }

            if (!Schema::hasColumn('seo_settings', 'publisher')) {
                $table->string('publisher')->nullable()->after('author');
            }

            if (!Schema::hasColumn('seo_settings', 'copyright')) {
                $table->string('copyright')->nullable()->after('publisher');
            }

            if (!Schema::hasColumn('seo_settings', 'site_name')) {
                $table->string('site_name')->nullable()->after('copyright');
            }

            if (!Schema::hasColumn('seo_settings', 'keywords')) {
                $table->text('keywords')->nullable()->after('site_name');
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
        Schema::table('seo_settings', function (Blueprint $table) {
            $columns = [
                'meta_title',
                'meta_description',
                'meta_image',
                'author',
                'publisher',
                'copyright',
                'site_name',
                'keywords',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('seo_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
