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
        Schema::create('panic_settings_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('panic_settings_id');
            $table->foreign('panic_settings_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('phone');
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
        Schema::dropIfExists('panic_settings_phones');
    }
};
