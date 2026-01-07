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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('employment_type')->nullable();
            $table->string('location')->nullable();
            $table->text('short_description')->nullable();
            $table->string('experience')->nullable();
            $table->string('salary')->nullable();
            $table->date('deadline')->nullable();
            $table->string('image')->nullable();
            $table->string('apply_url')->nullable();
            $table->integer('serial')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careers');
    }
};
