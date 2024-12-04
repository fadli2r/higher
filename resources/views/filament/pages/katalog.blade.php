<x-filament::page>
    <h1 class="text-2xl font-semibold mb-4">Daftar Produk</h1>

    <div class="flex justify-between space-x-6">
        <!-- Kolom Katalog Produk -->
        <div class="w-2/3">
            @livewire('product-list')
        </div>

        <!-- Kolom Keranjang -->
        <div class="w-1/3 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-semibold mb-4">Keranjang Belanja</h3>

            <!-- Menampilkan Livewire component untuk keranjang -->
            @livewire('cart')
        </div>
    </div>
</x-filament::page>
