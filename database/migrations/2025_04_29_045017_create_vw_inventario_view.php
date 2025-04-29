<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW `vw_inventario` AS select `p`.`id_producto` AS `id_producto`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`precio` AS `precio`,`p`.`stock_actual` AS `stock_actual`,`c`.`nombre` AS `categoria`,`pr`.`nombre` AS `proveedor` from ((`pasteleria`.`productos` `p` join `pasteleria`.`categorias` `c` on(`p`.`id_categoria` = `c`.`id_categoria`)) join `pasteleria`.`proveedores` `pr` on(`p`.`id_proveedor` = `pr`.`id_proveedor`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_inventario`");
    }
};
