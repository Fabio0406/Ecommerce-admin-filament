<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['fecha_pedido', 'total', 'id_cliente', 'id_empleado', 'estado']; // Agregamos 'estado'

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id');
    }

    // Relación con DetallePedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Función para obtener el estado en formato legible
    public function getEstadoLabelAttribute()
    {
        $estados = [
            'Pendiente' => 'Pendiente',
            'En proceso' => 'En proceso',
            'Enviado' => 'Enviado',
            'Entregado' => 'Entregado',
        ];

        return $estados[$this->estado] ?? 'Pendiente';
    }

    // En el modelo Pedido (Pedido.php)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedido', 'id_pedido', 'id_producto')
            ->withPivot('cantidad');
    }


}
