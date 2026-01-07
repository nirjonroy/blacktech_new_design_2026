<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            if (!Schema::hasColumn('careers', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
            if (!Schema::hasColumn('careers', 'key_responsibilities')) {
                $table->text('key_responsibilities')->nullable()->after('short_description');
            }
            if (!Schema::hasColumn('careers', 'requirements')) {
                $table->text('requirements')->nullable()->after('key_responsibilities');
            }
            if (!Schema::hasColumn('careers', 'why_join_us')) {
                $table->text('why_join_us')->nullable()->after('requirements');
            }
            if (!Schema::hasColumn('careers', 'apply_email')) {
                $table->string('apply_email')->nullable()->after('apply_url');
            }
            if (!Schema::hasColumn('careers', 'apply_details')) {
                $table->text('apply_details')->nullable()->after('apply_email');
            }
            if (!Schema::hasColumn('careers', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('status');
            }
            if (!Schema::hasColumn('careers', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('careers', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
        });

        if (Schema::hasColumn('careers', 'slug')) {
            $items = DB::table('careers')->select('id', 'title', 'slug')->get();
            $used = [];
            foreach ($items as $item) {
                if (!empty($item->slug)) {
                    $used[$item->slug] = true;
                    continue;
                }
                $base = Str::slug($item->title ?: 'career');
                if ($base === '') {
                    $base = 'career';
                }
                $slug = $base;
                $suffix = 1;
                while (isset($used[$slug]) || DB::table('careers')->where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $base . '-' . $suffix;
                    $suffix++;
                }
                $used[$slug] = true;
                DB::table('careers')->where('id', $item->id)->update(['slug' => $slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            if (Schema::hasColumn('careers', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('careers', 'key_responsibilities')) {
                $table->dropColumn('key_responsibilities');
            }
            if (Schema::hasColumn('careers', 'requirements')) {
                $table->dropColumn('requirements');
            }
            if (Schema::hasColumn('careers', 'why_join_us')) {
                $table->dropColumn('why_join_us');
            }
            if (Schema::hasColumn('careers', 'apply_email')) {
                $table->dropColumn('apply_email');
            }
            if (Schema::hasColumn('careers', 'apply_details')) {
                $table->dropColumn('apply_details');
            }
            if (Schema::hasColumn('careers', 'meta_title')) {
                $table->dropColumn('meta_title');
            }
            if (Schema::hasColumn('careers', 'meta_description')) {
                $table->dropColumn('meta_description');
            }
            if (Schema::hasColumn('careers', 'meta_keywords')) {
                $table->dropColumn('meta_keywords');
            }
        });
    }
};
