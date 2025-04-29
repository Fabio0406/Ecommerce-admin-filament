<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoResource\Pages;
use App\Models\Cliente;
use App\Models\Pedido;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;
    public static bool $canCreateAnother = false;

    protected static ?string $navigationIcon = 'bi-basket-fill';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('estado')
                ->options([
                    'Pendiente' => 'Pendiente',
                    'En proceso' => 'En proceso',
                    'Enviado' => 'Enviado',
                    'Entregado' => 'Entregado',
                ])
                ->default('Pendiente')
                ->required(),
            Forms\Components\TextInput::make('total')
                ->numeric()
                ->required(),
            Forms\Components\Select::make('id_cliente')
                ->options(Cliente::all()->pluck('nombre', 'id')->toArray())
                ->required()
                ->label('Cliente'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('cliente.nombre')
                ->label('Cliente')
                ->sortable(),
            Tables\Columns\TextColumn::make('estado')
                ->sortable()
                ->label('Estado'),
            Tables\Columns\TextColumn::make('total')
                ->sortable(),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('view_details')
                    ->label('Ver Detalles')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (Pedido $record): string => static::getUrl('view', ['record' => $record->id])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPedidos::route('/'),
            'edit' => Pages\EditPedido::route('/{record}/edit'),
            'view' => Pages\ViewPedido::route('/{record}'),
        ];
    }
    
    // Para deshabilitar la creación de pedidos
    public static function canCreate(): bool
    {
        return false;
    }
}