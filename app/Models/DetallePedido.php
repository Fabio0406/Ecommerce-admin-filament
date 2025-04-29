<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    
    // Especificar el nombre de la tabla en singular
    protected $table = 'detalle_pedido';

    protected $primaryKey = 'id_detalle';

    protected $fillable = ['id_pedido', 'id_producto', 'cantidad', 'precio_unitario', 'subtotal'];

    // Relación con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}