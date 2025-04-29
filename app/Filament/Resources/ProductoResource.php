<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


use App\Models\Proveedor;
use App\Models\Categoria;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;
    protected static ?string $navigationLabel = 'Productos';
    protected static ?string $navigationIcon = 'heroicon-s-cake';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(100),
            Forms\Components\Textarea::make('descripcion')
                ->nullable(),
            Forms\Components\TextInput::make('precio')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('stock_actual')
                ->numeric()
                ->default(0)
                ->required(),
            Forms\Components\Select::make('id_categoria')
                ->options(Categoria::all()->pluck('nombre', 'id')->toArray())
                ->required(),            
            // Campo para subir la imagen
            FileUpload::make('imagen')
                ->disk('public') // Usar el disco 'public' configurado en config/filesystems.php
                ->directory('productos') // Subir imágenes en la carpeta productos
                ->image()
                ->nullable()
                ->helperText('Sube una imagen del producto'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('precio')
                ->sortable(),
            Tables\Columns\TextColumn::make('stock_actual')
                ->sortable(),
            Tables\Columns\ImageColumn::make('imagen')
                ->label('Imagen')
                ->size(50),
            Tables\Columns\TextColumn::make('categoria.nombre')
                ->label('Categoría')
                ->sortable(),
            Tables\Columns\TextColumn::make('proveedor.nombre')
                ->label('Proveedor')
                ->sortable(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
