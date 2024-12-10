<div>
    <h2>Order Custom Design</h2>

    <form wire:submit.prevent="checkout">
        <!-- Pilih Desain Custom -->
        <div class="mb-4">
            <label for="customItemId">Choose a Design</label>
            <select id="customItemId" wire:model="customItemId" class="form-control">
                <option value="">Select Design</option>
                @foreach($customItems as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} - ${{ $item->base_price }}</option>
                @endforeach
            </select>
        </div>

        <!-- Pilih Ukuran -->
        <div class="mb-4">
            <label for="customSizeId">Choose a Size</label>
            <select id="customSizeId" wire:model="customSizeId" class="form-control">
                <option value="">Select Size</option>
                @foreach($customSizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size_name }} - ${{ $size->additional_price }}</option>
                @endforeach
            </select>
        </div>

        <!-- Deskripsi Permintaan -->
        <div class="mb-4">
            <label for="description">Description</label>
            <textarea id="description" wire:model="description" class="form-control" placeholder="Describe the customizations you want..."></textarea>
        </div>

        <!-- Harga Total -->
        <div class="mb-4">
            <h4>Total Price: ${{ number_format($totalPrice, 2) }}</h4>
        </div>

        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
