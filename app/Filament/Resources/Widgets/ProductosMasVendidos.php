<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductosMasVendidos extends Widget
{
    protected static ?int $sort = 10;
    protected static ?string $heading = 'Productos Más Vendidos';

    // El método render debe devolver una vista correctamente
    public function render(): View
{
    // Obtener los productos más vendidos en los pedidos entregados
    $productos = DB::table('productos')
        ->select('productos.nombre', DB::raw('SUM(detalle_pedido.cantidad) as total_vendido'))
        ->join('detalle_pedido', 'detalle_pedido.id_producto', '=', 'productos.id')
        ->join('pedidos', 'pedidos.id', '=', 'detalle_pedido.id_pedido')
        ->where('pedidos.estado', 'Entregado')  // Solo pedidos entregados
        ->groupBy('productos.nombre')  // Agrupar por el nombre del producto
        ->orderByDesc('total_vendido')  // Ordenar por los más vendidos
        ->limit(5)  // Limitar a los 5 más vendidos
        ->get();

    // Verificar si hay productos o mostrar un mensaje de no resultados
    if ($productos->isEmpty()) {
        $productos = collect([
            (object) ['nombre' => 'No hay productos más vendidos', 'total_vendido' => 0]
        ]);
    }

    // Pasamos los productos al Blade
    return view('filament.resources.dashboard-resource.widgets.productos-mas-vendidos', [
        'productos' => $productos,
    ]);
}

}


