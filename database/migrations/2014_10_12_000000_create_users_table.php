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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('display_picture')->nullable();
            $table->string('name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('loc')->nullable();
            $table->string('otp')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('new_password');
            $table->string('password');
            $table->enum('user_type', ['user', 'admin'])->nullable();
            $table->integer('created_by')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
