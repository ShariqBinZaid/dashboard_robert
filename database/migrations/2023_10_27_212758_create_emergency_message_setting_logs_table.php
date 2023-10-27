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
        Schema::create('emergency_setting_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergency_setting_id');
            $table->foreign('emergency_setting_id')->references('id')->on('emergency_settings')->onDelete('cascade');
            $table->string('name');
            $table->integer('phone');
            $table->longText('message');
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
        Schema::dropIfExists('emergency_message_setting_logs');
    }
};
