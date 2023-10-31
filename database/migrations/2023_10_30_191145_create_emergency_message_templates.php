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
        Schema::create('emergency_message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('message');
            $table->timestamps();
        });

        Schema::table('emergency_settings', function(Blueprint $table){
            $table->foreign('emergency_message_template_id')->references('id')->on('emergency_message_templates')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_message_templates');
    }
};
