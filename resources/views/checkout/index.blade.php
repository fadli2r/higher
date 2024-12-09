@extends('layout.template')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Shopping Cart</h1>
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example Item -->
                @foreach ($cart as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/60" alt="Item" class="img-thumbnail me-3"
                                style="width: 60px;">
                            <span>{{ $item->product->title }}</span>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control" value="1" min="1" disabled>
                    </td>
                    <td>@rupiah($item->product->price)</td>
                    <td>
                        <a href="{{ route('cart.destroy', $item->id) }}">
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </a>
                    </td>
                </tr>
                @endforeach
                <!-- Add more items as needed -->
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>
        <div>
            <h5>Total: <span class="text-success">@rupiah($cart->sum('product.price'))</span></h5>
            <a href="{{ route('cart.createOrder') }}" class="btn btn-primary">Checkout</a>
        </div>
    </div>
</div>
@endsection