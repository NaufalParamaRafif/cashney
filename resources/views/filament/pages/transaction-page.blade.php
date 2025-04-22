<x-filament-panels::page>
    {{-- outer div --}}
    <div class="flex flex-col gap-3 xl:flex-row">
        {{-- first div --}}
        <div class="flex flex-col gap-3 xl:w-[850px]" x-data="{ keyword: '' }">
            {{-- scrollable --}}
            <div class="flex w-full p-1 overflow-x-auto gap-2">
                {{-- @foreach ($categories as $category)
                    <div class="flex gap-2 bg-red-500 px-3 py-0.5 rounded-full" x-data="{ category: {{ $category }} }">
                        <span class="bg-white text-red-500 font-semibold px-2 rounded-full">{{ $category->totals() }}</span>
                        <p class="text-white font-semibold">{{ $category->name }}</p>
                    </div>
                @endforeach --}}
                <div class="flex bg-red-500 px-0.5 py-0.5 rounded-full w-full">
                    <input
                        type="text"
                        placeholder="Cari produk..."
                        x-model="keyword"
                        class="w-full bg-white text-red-500 placeholder-red-300 px-3 py-1 rounded-full focus:outline-none"
                    />
                </div>
            </div>
            {{-- item menu div --}}
            <div class="grid grid-cols-2 gap-3 mx-h-[580px] overflow-y-auto p-1">
                @foreach ($products as $product)
                    <div class="flex flex-col p-2 border rounded-md border-red-500 justify-evenly gap-2 transition duration-300 hover:-translate-y-1 select-none hover:cursor-pointer" x-show="'{{ strtolower($product->name) }}'.includes(keyword.toLowerCase())" x-on:click="$store.cart.add({{ $product }})">
                        <div class="flex flex-row">
                            <img class="border border-red-500 rounded-md mr-1.5 object-cover h-[4rem] w-[4rem]" src="{{ asset("storage/$product->image") }}" alt="">
                            <div class="flex flex-col justify-evenly">
                                <p class="text-xs">Stok: <span class="font-semibold">{{ $product->supply }} item</span></p>
                                <span class="p-0.5"></span>
                                <p class="text-xs">Kategori: <span class="font-semibold"><span>{{ $product->categories[0]->name ?? 'Tidak diketahui' }}</span></span></p>
                            </div>
                        </div>
                        <h3 class="text-xs font-bold">{{ $product->name }}</h4>
                        <p class="text-xs">Harga: <span class="font-semibold" x-text="rupiah({{ $product->price }})"></span></p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- order div --}}
        <div
            x-data
            x-on:transaction-finished.window="
                $store.cart.items = [];
                $store.cart.subtotal = 0;
                $store.cart.total = 0;
            "
            class="flex flex-col p-3.5 border rounded-md border-red-500 justify-evenly gap-2 lg:w-[480px]"
        >
            <h3 class="text-2xl font-bold">Order</h3>
            <div class="flex flex-col gap-2 max-h-[20rem] overflow-y-auto">
                <template x-for="(item, index) in $store.cart.items" :key="index">
                    <div class="flex flex-row border border-red-500 rounded-md shadow-md items-center p-1 select-none">
                        <img class="border border-red-500 rounded-md mr-1 object-cover h-[4rem] w-[4rem]" :src="'{{ asset("storage") }}/' + item.image" alt="">
                        <div class="flex flex-col justify-between grow self-stretch">
                            <h5 class="text-xs font-semibold mb-2" x-text="item.name"></h5>
                            <h6 class="text-xs font-semibold text-red-500" x-text="rupiah(item.price)"></h6>
                        </div>
                        <div class="flex flex-col justify-between self-stretch items-end w-48">
                            <h6 class="text-xs font-bold text-red-500" x-text="rupiah(item.total)"></h6>
                            <h6 class="flex flex-row gap-2 items-center text-sm font-bold mb-1">
                                <span class="p-1 px-2 rounded-full bg-red-500 text-white hover:cursor-pointer" x-on:click="$store.cart.add(item)">+</span> <span x-text="item.quantity"></span> <span class="p-1 px-2.5 rounded-full bg-red-500 text-white hover:cursor-pointer" x-on:click="$store.cart.remove(item.id)">-</span>
                            </h6>
                        </div>
                    </div>
                </template>
                {{-- item shopping --}}
            </div>
            {{-- Perhitungan --}}
            <div class="flex flex-col justify-around gap-2 rounded-lg border border-red-500 bg-black-100 text-sm font-medium p-3">
                <div class="flex font-bold">
                    <span class="w-2/6">Subtotal</span>
                    <span class="w-1/6">:</span>
                    <span class="w-3/6" x-text="$store.cart.subtotal <= 0 ? 'Rp 0' : rupiah($store.cart.subtotal)"></span>
                </div>
            </div>
            <button 
                wire:click="mountAction('checkoutAction', { items: $store.cart.items.map(item => ({'item_id': item.id, 'item_quantity': item.quantity})) })"
                class="bg-red-500 text-white rounded-full py-1 text-lg font-bold"
            >
                Checkout
            </button>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/myapp.js') }}"></script>
    @endpush
</x-filament-panels::page>