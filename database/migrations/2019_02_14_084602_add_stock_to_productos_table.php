<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStockToProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Añadimos la nueva columna, con valor por defecto 3
            // Así al crearla ya habrá al menos un elemento de stock
            $table->unsignedInteger('stock')->default('1')->after('tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Tiramos la columna abajo
            $table->dropColumn('stock');
        });
    }
}
