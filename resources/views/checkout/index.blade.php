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
                        <input type="number" class="form-control" value="{{ $item->quantity }}" min="1" disabled>
                    </td>
                    <td>@rupiah($item->product->price * $item->quantity)</td>
                    <td>
                        <a href="{{ route('cart.destroy', $item->id) }}">
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Form Kupon -->
    <div class="mt-4">
        <form action="{{ route('cart.applyCoupon') }}" method="POST">
            @csrf
            <div class="d-flex">
                <input type="text" name="coupon_code" class="form-control me-2" placeholder="Enter coupon code" required>
                <button type="submit" class="btn btn-success">Apply Coupon</button>
            </div>
        </form>

        @if(session('discount'))
        <div class="alert alert-success mt-2">
            Coupon applied! You get a discount of: <strong>@rupiah(session('discount'))</strong>
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
        @endif
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>
        <div>
            <h5>Total: <span class="text-success">@rupiah($cart->sum(function ($item) { return $item->product->price * $item->quantity; }) - session('discount', 0))</span></h5>
            <a href="{{ route('cart.createOrder') }}" class="btn btn-primary">Checkout</a>
        </div>
    </div>
</div>
@endsection
