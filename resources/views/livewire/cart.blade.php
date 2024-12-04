<div class="space-y-4">
    @if(count($cart) > 0)
        <div class="space-y-3">
            @foreach($cart as $productId => $product)
                <x-filament::card class="p-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <img src="{{ $product['image_url'] }}" class="w-16 h-16 object-cover rounded-md mr-4" alt="{{ $product['name'] }}">
                        <div>
                            <h4 class="text-lg font-semibold">{{ $product['name'] }}</h4>
                            <p class="text-sm">Qty: {{ $product['quantity'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm">Rp {{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }}</span>



                    </div>
                    <x-filament::button wire:click="removeFromCart({{ $productId }})" color="danger" icon="heroicon-o-trash" size="sm">
                            Hapus
                        </x-filament::button>
                </x-filament::card>
            @endforeach
        </div>

        <div class="flex justify-between items-center">
            <span class="text-xl font-semibold">Total: Rp {{ number_format($this->getTotalPrice(), 0, ',', '.') }}</span>
            <x-filament::button color="success" class="w-full mt-4">Checkout</x-filament::button>
        </div>
    @else
        <p class="text-center text-gray-500">Keranjang Anda kosong.</p>
    @endif
</div>
