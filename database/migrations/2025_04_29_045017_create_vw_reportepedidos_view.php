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
        DB::statement("CREATE VIEW `vw_reportepedidos` AS select `p`.`id_pedido` AS `id_pedido`,`p`.`fecha_pedido` AS `fecha_pedido`,`p`.`total` AS `total`,`c`.`nombre` + ' ' + `c`.`apellido` AS `cliente`,count(`dp`.`id_detalle`) AS `cantidad_productos`,sum(`dp`.`cantidad`) AS `total_unidades` from ((`pasteleria`.`pedidos` `p` join `pasteleria`.`clientes` `c` on(`p`.`id_cliente` = `c`.`id_cliente`)) join `pasteleria`.`detalle_pedido` `dp` on(`p`.`id_pedido` = `dp`.`id_pedido`)) group by `p`.`id_pedido`,`p`.`fecha_pedido`,`p`.`total`,`c`.`nombre`,`c`.`apellido`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_reportepedidos`");
    }
};
