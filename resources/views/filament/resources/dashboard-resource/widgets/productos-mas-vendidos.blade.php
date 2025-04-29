<div class="p-4 bg-gray-800 text-white rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-center mb-4">Productos Más Vendidos</h3>
    
    @if ($productos->first()->nombre === 'No hay productos más vendidos')
        <p class="text-center text-gray-400">No hay productos más vendidos en este momento.</p>
    @else
        <ul class="space-y-3">
            @foreach ($productos as $producto)
                <li class="flex justify-between">
                    <span>{{ $producto->nombre }}</span>
                    <span class="font-semibold">{{ $producto->total_vendido }} unidades</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
