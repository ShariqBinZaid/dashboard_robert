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
        Schema::create('emergency_message_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergency_settings_id');
            $table->foreign('emergency_settings_id')->references('id')->on('emergency_settings')->cascadeOnUpdate();
            $table->dateTime('schedule_time');
            $table->tinyInteger('is_repeat')->nullable()->default(0);
            $table->string('ringtone');
            $table->tinyInteger('can_vibrate')->nullable()->default(0);
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
        Schema::dropIfExists('emergency_message_schedules');
    }
};
