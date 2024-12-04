<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($products as $product)
        <div class="bg-white border border-gray-300 rounded-lg shadow-lg p-4">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
            <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>

            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-900">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500">{{ $product->stock }} stok</span>
            </div>

            <div class="mt-4">
                <x-filament::button wire:click="addToCart({{ $product->id }})" color="primary" class="w-full">Tambah ke Keranjang</x-filament::button>

            </div>
        </div>
    @endforeach
</div>

