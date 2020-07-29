<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->defautl('');
            $table->string('code')->defautl('');
            $table->string('category')->defautl('');
            $table->string('type')->nullable();
            $table->string('product_name')->defautl('');
            $table->string('supplier')->nullable();
            $table->string('brand')->nullable();
            $table->double('price')->defautl(0);
            $table->timestamps();
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
        Schema::dropIfExists('nd_products');
    }
}
