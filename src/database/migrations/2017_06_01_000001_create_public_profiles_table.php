<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Public_Profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('lastname');
            $table->string('nickname')->unique();
            $table->string('email')->nullable(true)->unique();
            $table->string('phone')->nullable(true);
            $table->string('cover_image')->nullable(true);
            $table->string('profile_image')->nullable(true);
            $table->boolean('status')->nullable(true);
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
        Schema::drop('Public_Profiles');
    }
}
