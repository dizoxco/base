<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->char('brand', 100);
            $table->char('slug', 100)->unique()->nullable();
            $table->char('province', 100);
            $table->char('city', 100);
            $table->char('tell', 8);
            $table->char('phone_code', 3);
            $table->string('address');
            $table->char('postal_code', 10);
            $table->char('mobile', 11);
            $table->string('storage_address');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
