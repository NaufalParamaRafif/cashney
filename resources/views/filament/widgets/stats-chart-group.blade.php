<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @livewire(\App\Filament\Widgets\ProductSoldChart::class)
            @livewire(\App\Filament\Widgets\UserGrowthChart::class)
        </div>
    </x-filament::card>
</x-filament::widget>
