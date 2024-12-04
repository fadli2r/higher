<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductList extends Component
{
    public $cart = [];

    // Menambahkan produk ke keranjang
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            if (isset($this->cart[$productId])) {
                $this->cart[$productId]['quantity']++;
            } else {
                $this->cart[$productId] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'image_url' => $product->image_url
                ];
            }

            // Menyimpan keranjang dalam sesi
            session()->put('cart', $this->cart);
        }

        // Mengupdate UI dengan sesi baru
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $products = Product::all(); // Ambil semua produk dari database
        return view('livewire.product-list', compact('products'));
    }
}
