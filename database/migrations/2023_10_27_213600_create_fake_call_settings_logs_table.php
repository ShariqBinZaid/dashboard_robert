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
        Schema::create('fake_call_settings_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fake_call_settings_id');
            $table->foreign('fake_call_settings_id')->references('id')->on('fake_call_settings')->onDelete('cascade');
            $table->string('name');
            $table->integer('phone');
            $table->dateTime('time');
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
        Schema::dropIfExists('fake_call_settings_logs');
    }
};
