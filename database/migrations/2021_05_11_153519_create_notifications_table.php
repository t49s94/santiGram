<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->string('notification_type');
            $table->string('body');
            $table->boolean('seen');
            $table->timestamps();

            $table->foreign('receiver_id')->references('id')
            ->on('profiles')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('sender_id')->references('id')
            ->on('profiles')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->index('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
