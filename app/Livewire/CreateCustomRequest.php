<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CustomRequest;
use App\Models\CustomItem;
use App\Models\CustomSize;
use App\Models\Order;

class CreateCustomRequest extends Component
{
    public $customItemId;
    public $customSizeId;
    public $description;
    public $totalPrice = 0;

    public function render()
    {
        return view('livewire.create-custom-request', [
            'customItems' => CustomItem::all(),
            'customSizes' => CustomSize::all(),
        ]);
    }

    // Menghitung harga total saat memilih desain dan ukuran
    public function updatedCustomItemId($value)
    {
        $customItem = CustomItem::find($value);
        $this->totalPrice = $customItem->base_price + ($this->customSizeId ? CustomSize::find($this->customSizeId)->additional_price : 0);
    }

    public function updatedCustomSizeId($value)
    {
        $customSize = CustomSize::find($value);
        $this->totalPrice = ($this->customItemId ? CustomItem::find($this->customItemId)->base_price : 0) + $customSize->additional_price;
    }

    public function checkout()
    {
        $this->validate([
            'customItemId' => 'required',
            'customSizeId' => 'required',
            'description' => 'required',
        ]);

        // Simpan data CustomRequest
        $customRequest = CustomRequest::create([
            'user_id' => auth()->id(),
            'description' => $this->description,
            'price' => $this->totalPrice,
            'status' => 'pending',
        ]);

        // Simpan item desain dan ukuran dalam custom_request_items
        $customRequest->customRequestItems()->create([
            'custom_item_id' => $this->customItemId,
            'custom_size_id' => $this->customSizeId,
            'quantity' => 1,  // Default quantity, Anda bisa menambahkan field jumlah
        ]);

        // Simpan data Order terkait
        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $this->customItemId,
            'total_price' => $this->totalPrice,
            'order_status' => 'pending',
        ]);

        session()->flash('message', 'Your custom design order has been placed successfully!');
        return redirect()->route('order.confirmation', $order->id);
    }
}
