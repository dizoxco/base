<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesProductsTable extends Migration
{
    /**
     * Run the migrations.
     * @deprecated No longer used by internal code and not recommended.
     * @return void
     */
    public function up()
    {
        Schema::create('businesses_products', function (Blueprint $table) {
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('product_id');
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses_products');
    }
}
