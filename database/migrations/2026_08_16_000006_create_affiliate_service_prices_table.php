<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('affiliate_service_prices', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->decimal('basic_price', 12, 2)->nullable();
            $table->decimal('intermediate_price', 12, 2)->nullable();
            $table->decimal('complex_price', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->integer('serial')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('affiliate_service_prices');
    }
};
