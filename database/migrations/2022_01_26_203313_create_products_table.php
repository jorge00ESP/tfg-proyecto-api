<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 20);
            $table->smallInteger('precio');
            $table->smallInteger('cantidad');
            $table->string('descripcion', 100)->nullable();
            $table->unsignedBigInteger('id_categoria')->nullable();

            $table->foreign('id_categoria')->references('id')->on('categories');

                //$table->foreign('id_user_emisor')->references('id')->on('users');

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
        Schema::dropIfExists('products');
    }
}
