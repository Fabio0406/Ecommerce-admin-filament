<x-filament-panels::page>
    <main class="space-y-6">
        <h1 class="text-xl font-semibold">Detalles del Pedido</h1>

        <div>
            <h2 class="font-medium">Cliente: {{ $pedido->cliente->nombre }}</h2>
            <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
            <p><strong>Total:</strong> ${{ $pedido->total }}</p>
            <p><strong>Fecha de Pedido:</strong> {{ $pedido->created_at }}</p>

            <h3 class="mt-4 font-medium">Productos en el Pedido:</h3>
            @if($pedido->productos->isEmpty())
                <p>No hay productos en este pedido.</p>
            @else
                <ul>
                    @foreach ($pedido->productos as $producto)
                        <li>{{ $producto->nombre }} - {{ $producto->pivot->cantidad }} unidades</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </main>
</x-filament-panels::page>