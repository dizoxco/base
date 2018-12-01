<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            //  todo:if all users including guests can send comment change this to email
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->text('body');
            $table->morphs('commentable');
            $table->boolean('verify')->default(false);
            //  todo:decide about like and dislike fields
            //$table->unsignedInteger('like');
            //$table->unsignedInteger('dislike');
            $table->softDeletes();
            $table->timestamps();
            //  todo:if all users including guests can send comment change this to email
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
