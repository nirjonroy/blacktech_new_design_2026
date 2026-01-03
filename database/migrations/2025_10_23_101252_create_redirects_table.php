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
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('source_url');
            $table->string('match_type', 20)->default('exact');
            $table->boolean('is_case_sensitive')->default(false);
            $table->string('destination_url');
            $table->unsignedSmallInteger('http_code')->default(301);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['match_type', 'is_active']);
            $table->index(['source_url', 'match_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redirects');
    }
};
