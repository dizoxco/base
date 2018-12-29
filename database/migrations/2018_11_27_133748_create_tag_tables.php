<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->unsignedInteger('taxonomy_id')->nullable();
            $table->string('label');
            $table->string('slug')->unique();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedInteger('tag_id')->index();
            $table->unsignedInteger('taggable_id');
            $table->char('taggable_type', 100);
            $table->index(['taggable_id', 'taggable_type']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('taggables');
        Schema::drop('tags');
        Schema::drop('taxonomies');
    }
}
