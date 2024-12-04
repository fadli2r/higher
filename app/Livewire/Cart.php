<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;


class Cart extends Component
{
    public $cart = [];

    // Menangani event cartUpdated untuk memuat ulang keranjang setelah perubahan
    protected $listeners = ['cartUpdated' => 'mount'];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    // Menghitung total harga keranjang
    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->cart as $product) {
            $total += $product['price'] * $product['quantity'];
        }
        return $total;
    }
    // Menghapus item dari keranjang
    public function removeFromCart($productId)
    {
        // Menghapus produk dari cart
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
        }

        // Update keranjang di session
        session()->put('cart', $this->cart);

        // Emit event untuk memberitahukan komponen lainnya
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
