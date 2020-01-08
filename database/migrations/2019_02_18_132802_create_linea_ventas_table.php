<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_ventas', function (Blueprint $table) {
            $table->increments('id');
            // Relaciones
            $table->integer('venta_id')->unsigned(); // Clave externa
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            // Otros campos
            $table->string('producto');
            $table->double('precio', 8, 2);
            $table->integer('cantidad');
            $table->double('total', 8, 2);
            // Relaciones
            $table->integer('producto_id')->unsigned(); // Clave externa
            $table->foreign('producto_id')->references('id')->on('productos');//->onDelete('cascade');
            
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
        Schema::dropIfExists('linea_ventas');
    }
}
