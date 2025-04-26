<div class="flex flex-col">
    <span class="font-medium">{{ $discount->name }} ({{ $discount->code }})</span>
    <div class="flex flex-col gap-2 text-xs text-gray-500">
        <div class="space-y-1">

            @switch($discount->categories)
            @case('nominal')
                <div class="text-green-600 font-medium">
                    Diskon: Rp{{ number_format($discount->nominal_discount) }}
                </div>
                @break
            @case('persentase')
                <div class="text-green-600 font-medium">
                    Diskon: {{ $discount->persentase_harga_diskon }}%
                </div>
                @break
            @case('paket')
                <div class="flex flex-col">
                    <span class="text-green-600 font-medium">
                        Paket: Beli {{ $discount->minimum_but_discount }}
                    </span>
                    <span class="text-blue-600">
                        Gratis: {{ $discount->get_discount }}
                    </span>
                </div>
                @break
            @case('cashback')
                <div class="text-purple-600 font-medium">
                    Cashback: Rp{{ number_format($discount->cashback_discount) }}
                </div>
                @break
            @default
                <div class="text-gray-500">
                    Jenis diskon tidak diketahui
                </div>
            @endswitch
        </div>


        {{-- <div>•</div> --}}
        <div>Min. beli: Rp{{ number_format($discount->minimum_purchase_price) }}</div>
        @if($discount->end_date)
            <div>Berlaku hingga: {{ $discount->end_date }}</div>
        @endif
        @if($discount->max_used)
            <div>Maksimal Pengguna: {{ $discount->max_used }}, Digunakan: {{ $discount->used }}</div>
        @endif
    </div>
</div>