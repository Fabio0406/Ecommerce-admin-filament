<?php

namespace App\Filament\Resources\Widgets;

use App\Models\Pedido;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PedidoDashboardWidget extends ChartWidget
{
    protected static ?string $heading = 'Estado de los Pedidos';

    // Establecer la altura máxima del gráfico
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        // Datos para el gráfico de estado de pedidos
        $pedidoCounts = Pedido::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos por Estado',
                    'data' => [
                        $pedidoCounts['Pendiente'] ?? 0,
                        $pedidoCounts['En proceso'] ?? 0,
                        $pedidoCounts['Entregado'] ?? 0,
                    ],
                    'backgroundColor' => ['#ff6347', '#ffa500', '#32cd32'],
                    'borderWidth' => 0, // Eliminar los bordes
                ],
            ],
            'labels' => ['Pendiente', 'En proceso', 'Entregado'],
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Tipo de gráfico: torta
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => true,
            'responsive' => true,
            'scales' => [
                'x' => [
                    'display' => false, // Eliminar las líneas del gráfico
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
