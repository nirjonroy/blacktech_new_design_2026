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
        $tables = ['blogs', 'products', 'child_categories'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'seo_description')) {
                    if (! Schema::hasColumn($tableName, 'meta_title')) {
                        $table->string('meta_title')->nullable()->after('seo_description');
                    }
                    if (! Schema::hasColumn($tableName, 'meta_description')) {
                        $table->text('meta_description')->nullable()->after('meta_title');
                    }
                } else {
                    if (! Schema::hasColumn($tableName, 'meta_title')) {
                        $table->string('meta_title')->nullable();
                    }
                    if (! Schema::hasColumn($tableName, 'meta_description')) {
                        $table->text('meta_description')->nullable();
                    }
                }

                if (! Schema::hasColumn($tableName, 'meta_image')) {
                    $table->string('meta_image')->nullable()->after('meta_description');
                }
                if (! Schema::hasColumn($tableName, 'author')) {
                    $table->string('author')->nullable()->after('meta_image');
                }
                if (! Schema::hasColumn($tableName, 'publisher')) {
                    $table->string('publisher')->nullable()->after('author');
                }
                if (! Schema::hasColumn($tableName, 'copyright')) {
                    $table->string('copyright')->nullable()->after('publisher');
                }
                if (! Schema::hasColumn($tableName, 'site_name')) {
                    $table->string('site_name')->nullable()->after('copyright');
                }
                if (! Schema::hasColumn($tableName, 'keywords')) {
                    $table->text('keywords')->nullable()->after('site_name');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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

        foreach (['blogs', 'products', 'child_categories'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($columns, $tableName) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
