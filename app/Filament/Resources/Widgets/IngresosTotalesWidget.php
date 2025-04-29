<?php
namespace App\Filament\Widgets;

use App\Models\Pedido;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IngresosTotalesWidget extends ChartWidget
{
    protected static ?int $sort = 5;
    
    protected static ?string $heading = 'Ingresos Totales';

    // Podemos añadir un filtro para elegir tipo de gráfico
    protected int $refreshRate = 300; // Actualizar cada 5 minutos (opcional)

    protected function getData(): array
    {
        // Obtener el mes y año actual
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;
        
        // Nombre del mes en español
        $nombreMes = Carbon::now()->locale('es')->monthName;

        // Obtener los ingresos solo del mes actual
        $ingresosMensuales = Pedido::where('estado', 'Entregado')
            ->whereYear('created_at', $anioActual)
            ->whereMonth('created_at', $mesActual)
            ->sum('total');

        // Obtener ingresos por día para el mes actual
        $ingresosPorDia = Pedido::where('estado', 'Entregado')
            ->whereYear('created_at', $anioActual)
            ->whereMonth('created_at', $mesActual)
            ->select(
                DB::raw('DAY(created_at) as dia'),
                DB::raw('SUM(total) as total_diario')
            )
            ->groupBy('dia')
            ->orderBy('dia')
            ->pluck('total_diario', 'dia')
            ->toArray();
        
        // Generar array para todos los días del mes
        $diasDelMes = Carbon::now()->daysInMonth;
        $datos = [];
        $etiquetas = [];
        
        for ($dia = 1; $dia <= $diasDelMes; $dia++) {
            $etiquetas[] = $dia; // Día del mes
            $datos[] = $ingresosPorDia[$dia] ?? 0; // Si no hay ingresos, 0
        }

        return [
            'datasets' => [
                [
                    'label' => "Ingresos de $nombreMes $anioActual",
                    'data' => $datos,
                    'backgroundColor' => '#4CAF50',
                    'borderColor' => '#4CAF50',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.4, // Curvas más suaves
                ],
            ],
            'labels' => $etiquetas,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipo de gráfico: línea
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => 'Total: $' . number_format($this->getTotalMes(), 2),
                    'position' => 'bottom',
                    'font' => [
                        'size' => 16,
                        'weight' => 'bold',
                    ],
                ],
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            return '$' + context.parsed.y.toFixed(2);
                        }",
                    ],
                ],
            ],
            'scales' => [
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Día del mes',
                    ],
                ],
                'y' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Ingresos ($)',
                    ],
                    'ticks' => [
                        'callback' => "function(value) {
                            return '$' + value;
                        }",
                    ],
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    // Método auxiliar para calcular el total del mes
    private function getTotalMes(): float
    {
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;

        return Pedido::where('estado', 'Entregado')
            ->whereYear('created_at', $anioActual)
            ->whereMonth('created_at', $mesActual)
            ->sum('total');
    }

    // Método para mostrar información adicional debajo del gráfico
    protected function getFooter(): string
    {
        $nombreMes = Carbon::now()->locale('es')->monthName;
        return "Ingresos del mes de $nombreMes";
    }
}