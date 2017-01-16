<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_feedback_id');
            $table->integer('guest_id');
            $table->text('feedback');
            $table->string('guest_nickname');
            $table->boolean('status', false);
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
        Schema::drop('Feedbacks');
    }
}
