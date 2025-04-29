<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            Detalles del Pedido #{{ $record->id }}
        </x-slot>
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium">Información del Pedido</h3>
                    <dl class="mt-2 space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cliente</dt>
                            <dd class="mt-1 text-sm">{{ $record->cliente->nombre ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1 text-sm">{{ $record->estado }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total</dt>
                            <dd class="mt-1 text-sm">${{ number_format($record->total, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Pedido</dt>
                            <dd class="mt-1 text-sm">{{ $record->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="mt-6">
                <h3 class="text-lg font-medium mb-4">Detalle del Pedido</h3>
                {{ $this->table }}
            </div>
        </div>
    </x-filament::section>
</x-filament::page>