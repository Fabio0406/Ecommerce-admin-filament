<?php

namespace App\Filament\Pages;

use App\Models\Pedido;
use Filament\Pages\Page;

class PedidoShowPage extends Page
{
    // Definir la vista que se utilizará
    protected static string $view = 'filament.pedidos.show';

    // Instancia del modelo Pedido
    public Pedido $pedido;

    // Método para inicializar la página con el pedido correspondiente
    public function mount(Pedido $pedido)
    {

        return view('filament.pedidos.show', [
            'productos' => $pedido,
        ]);

    }
}
