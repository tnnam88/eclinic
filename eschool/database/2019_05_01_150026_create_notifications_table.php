<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('receiver_id')->nullable();
            $table->unsignedInteger('sender_id')->nullable();
            $table->boolean('checked')->default(0);
            $table->unsignedInteger('post_id')->nullable();
            $table->unsignedInteger('mail_id')->nullable();
            $table->unsignedInteger('comment_id')->nullable();
            $table->unsignedInteger('result_id')->nullable();
            $table->string('content');
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
        Schema::dropIfExists('notifications');
    }
}
