<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id'); // ID de Venta
            $table->string('codigo')->unique();
            $table->dateTime('fecha');
            $table->double('total', 8, 2);
            $table->double('subtotal', 8, 2);
            $table->double('iva', 8, 2);

            // Relaciones
            $table->integer('user_id')->unsigned(); // Clave externa
            $table->foreign('user_id')->references('id')->on('users');//->onDelete('cascade');

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
        Schema::dropIfExists('ventas');
    }
}
