<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdCustomerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_customer_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_buys_id');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('email')->nullable();
            $table->string('phone')->default('');
            $table->string('postal_code')->default('');
            $table->string('state')->default('');
            $table->string('municipality')->default('');
            $table->string('colony')->default('');
            $table->string('street')->default('');
            $table->string('no_ext')->default('');
            $table->string('no_int')->nullable();
            $table->foreignId('nd_address_types_id');
            $table->string('references', 1000)->default('');
            $table->foreignId('nd_parkings_id');
            $table->string('package')->default('');
            $table->foreignId('nd_themathics_id');
            $table->string('modifications', 1000)->nullable();
            $table->string('observations', 1000)->nullable();
            $table->foreignId('nd_contact_means_id');
            $table->string('contact_mean_other')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
            $table->foreign('nd_address_types_id')->references('id')->on('nd_address_types');
            $table->foreign('nd_parkings_id')->references('id')->on('nd_parkings');
            $table->foreign('nd_themathics_id')->references('id')->on('nd_themathics');
            $table->foreign('nd_contact_means_id')->references('id')->on('nd_contact_means');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nd_customer_forms');
    }
}
