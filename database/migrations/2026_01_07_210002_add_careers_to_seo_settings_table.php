<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
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
        if (!Schema::hasTable('seo_settings')) {
            return;
        }

        $exists = DB::table('seo_settings')
            ->where('page_name', 'Careers')
            ->exists();

        if ($exists) {
            return;
        }

        $data = [
            'page_name' => 'Careers',
            'seo_title' => 'Careers',
            'seo_description' => 'Explore open positions at Blacktech and build your career with our team.',
        ];

        if (Schema::hasColumn('seo_settings', 'meta_title')) {
            $data['meta_title'] = 'Careers';
        }
        if (Schema::hasColumn('seo_settings', 'meta_description')) {
            $data['meta_description'] = 'Discover current job opportunities at Blacktech. Join our team and grow with us.';
        }
        if (Schema::hasColumn('seo_settings', 'site_name')) {
            $data['site_name'] = null;
        }
        if (Schema::hasColumn('seo_settings', 'author')) {
            $data['author'] = 'Blacktech';
        }

        DB::table('seo_settings')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('seo_settings')) {
            return;
        }

        DB::table('seo_settings')
            ->where('page_name', 'Careers')
            ->delete();
    }
};
