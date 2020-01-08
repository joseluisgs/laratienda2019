<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titular');
            $table->enum('tipo', ['Visa','MasterCard','AmericanExpress','Discover','PayPal'])->default('Visa');
            $table->string('numero');
            $table->string('cvv');
            $table->integer('mes');
            $table->integer('año');

            // Relaciones
            $table->integer('venta_id')->unsigned(); // Clave externa
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');

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
        Schema::dropIfExists('pagos');
    }
}
