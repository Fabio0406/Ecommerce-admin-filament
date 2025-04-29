<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use App\Models\DetallePedido;
use App\Models\Pedido;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;

class ViewPedido extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = PedidoResource::class;

    protected static string $view = 'filament.resources.pedido-resource.page.view-pedido';

    public $record;

    public function mount($record): void
    {
        $this->record = Pedido::findOrFail($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Puedes añadir acciones en el encabezado si lo deseas
        ];
    }

    protected function getTableQuery(): Builder
    {
        return DetallePedido::query()
            ->where('id_pedido', $this->record->id)
            ->orderBy('id_producto'); // O cualquier columna que exista en tu tabla
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('producto.nombre')
                ->label('Producto')
                ->sortable(),
            Tables\Columns\TextColumn::make('cantidad')
                ->sortable(),
            Tables\Columns\TextColumn::make('precio_unitario')
                ->money('mxn')
                ->sortable(),
            Tables\Columns\TextColumn::make('subtotal')
                ->money('mxn')
                ->sortable(),
        ];
    }

    public function getTitle(): string
    {
        return 'Detalle de pedido #' . $this->record->id;
    }

    public function getBreadcrumb(): string
    {
        return 'Detalle de pedido';
    }

    // Configurar la tabla para deshabilitar el ordenamiento automático por ID
    protected function configure(): void
    {
        $this->table->defaultSort(false);
    }
}