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
        Schema::create('fake_text_settings_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fake_text_setting_id');
            $table->foreign('fake_text_setting_id')->references('id')->on('fake_text_settings')->onDelete('cascade');
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
        Schema::dropIfExists('fake_text_settings_logs');
    }
};
