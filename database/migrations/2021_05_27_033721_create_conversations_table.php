<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('conversations', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('sender_id');
          $table->unsignedBigInteger('receiver_id');
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
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
