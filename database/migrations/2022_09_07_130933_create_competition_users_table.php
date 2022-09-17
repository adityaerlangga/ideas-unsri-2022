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
        Schema::create('competition_users', function (Blueprint $table) {
            $table->id();
            // Team
            $table->string("competition", 255)->nullable();
            $table->string("team_name", 255)->nullable();
            $table->string("university", 255)->nullable();
            $table->string("ktm", 255)->nullable();
            // Personal Data
            $table->string("leader_name", 255)->nullable();
            $table->string("leader_number", 255)->nullable();
            $table->string("leader_major", 255)->nullable();
            $table->string("leader_email", 255)->nullable();
            $table->string("leader_birth_date", 255)->nullable();
            $table->string("member1_name", 255)->nullable();
            $table->string("member1_number", 255)->nullable();
            $table->string("member1_major", 255)->nullable();
            $table->string("member1_email", 255)->nullable();
            $table->string("member2_name", 255)->nullable();
            $table->string("member2_number", 255)->nullable();
            $table->string("member2_major", 255)->nullable();
            $table->string("member2_email", 255)->nullable();
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
        Schema::dropIfExists('competition_users');
    }
};