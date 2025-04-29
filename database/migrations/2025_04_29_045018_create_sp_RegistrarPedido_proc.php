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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_RegistrarPedido`(
    IN id_cliente INT,
    IN id_empleado INT,
    IN detalles_pedido JSON,
    OUT id_pedido_out INT
)
BEGIN
    DECLARE total DECIMAL(10,2) DEFAULT 0;
    DECLARE subtotal DECIMAL(10,2);
    DECLARE cantidad INT;
    DECLARE precio_unitario DECIMAL(10,2);
    DECLARE id_producto INT;
    DECLARE i INT DEFAULT 0;
    DECLARE detalle_count INT;

    -- Obtener la cantidad de detalles en el JSON
    SET detalle_count = JSON_LENGTH(detalles_pedido);

    -- Insertar el pedido
    INSERT INTO PEDIDOS (fecha_pedido, total, id_cliente, id_empleado)
    VALUES (CURRENT_TIMESTAMP, 0, id_cliente, id_empleado);

    -- Obtener el ID del pedido generado
    SET id_pedido_out = LAST_INSERT_ID();

    -- Iterar sobre los detalles del pedido
    WHILE i < detalle_count DO
        -- Obtener los valores del detalle
        SET id_producto = JSON_UNQUOTE(JSON_EXTRACT(detalles_pedido, CONCAT('$[', i, '].id_producto')));
        SET cantidad = JSON_UNQUOTE(JSON_EXTRACT(detalles_pedido, CONCAT('$[', i, '].cantidad')));

        -- Obtener el precio unitario del producto
        SELECT precio INTO precio_unitario FROM PRODUCTOS WHERE id_producto = id_producto;

        -- Calcular el subtotal
        SET subtotal = precio_unitario * cantidad;

        -- Insertar en el detalle del pedido
        INSERT INTO DETALLE_PEDIDO (id_pedido, id_producto, cantidad, precio_unitario, subtotal)
        VALUES (id_pedido_out, id_producto, cantidad, precio_unitario, subtotal);

        -- Actualizar el stock del producto
        UPDATE PRODUCTOS 
        SET stock_actual = stock_actual - cantidad
        WHERE id_producto = id_producto;

        -- Sumar el subtotal al total
        SET total = total + subtotal;

        -- Incrementar el índice para la siguiente iteración
        SET i = i + 1;
    END WHILE;

    -- Actualizar el total en el pedido
    UPDATE PEDIDOS SET total = total WHERE id_pedido = id_pedido_out;
    
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_RegistrarPedido");
    }
};
