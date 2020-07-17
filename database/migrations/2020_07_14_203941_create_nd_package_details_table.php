<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdPackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_buys_id');
            $table->integer('quantity');
            $table->string('package');
            $table->string('modifications', 1000)->default('');
            $table->double('delivery_price')->default(0);
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
        Schema::dropIfExists('nd_package_details');
    }
}
