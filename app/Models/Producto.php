<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock_actual', 'id_categoria', 'id_proveedor', 'imagen']; // Agregamos 'imagen'

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id');
    }

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id');
    }

    // Relación con DetallePedido
    public function detallesPedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Función para obtener la URL de la imagen
    public function getImagenUrlAttribute()
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : asset('images/default_product.png'); // URL de la imagen
    }

    // En el modelo Producto (Producto.php)
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'detalle_pedido', 'id_producto', 'id_pedido')
            ->withPivot('cantidad');
    }

}
