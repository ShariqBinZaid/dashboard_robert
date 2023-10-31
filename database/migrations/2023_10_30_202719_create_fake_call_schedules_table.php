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
        Schema::create('fake_call_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fake_call_settings_id');
            $table->foreign('fake_call_settings_id')->references('id')->on('fake_call_settings')->cascadeOnUpdate();
            $table->dateTime('schedule_time');
            $table->tinyInteger('is_repeat')->nullable()->default(0);
            $table->string('ringtone')->nullable();
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
        Schema::dropIfExists('fake_call_schedules');
    }
};
