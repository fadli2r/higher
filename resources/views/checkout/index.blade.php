@extends('layout.template')
@section('styles')
<style>
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: white;
    border-bottom: 1px solid #ddd;
}
ul {
    list-style: none;
    margin-bottom: 20px;
    padding-top: 20px;
}

.logo {
    font-size: 24px;
    font-weight: bold;
}

.menu ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

.menu a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
}

.menu a:hover {
    color: #007BFF;
}

.icons {
    display: flex;
    gap: 15px;
}

.icon {
    text-decoration: none;
    font-size: 20px;
    color: #333;
}

.icon:hover {
    color: #007BFF;
}

/* Responsif */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
    }

    .menu ul {
        flex-direction: column;
        gap: 10px;
    }
}
    </style>
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
                @forelse ($cart as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/60' }}"
                                 alt="Item" class="img-thumbnail me-3" style="width: 60px;">

                            <span>
                                {{ $item->product?->title ?? $item->customRequest?->description }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <input type="number" class="form-control" value="{{ $item->quantity }}" min="1" disabled>
                    </td>

                    <td>
                        @php
                            $price = $item->product?->price ?? $item->customRequest?->price;
                        @endphp
                        @if($price)
                            @rupiah($price * $item->quantity)
                        @else
                            <span class="text-muted">Not Available</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('cart.destroy', $item->id) }}" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Your cart is empty.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Form Kupon -->
    <div class="mt-4">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>

        <h5>
            Total:
            <span class="text-success">
                @rupiah($cart->sum(function ($item) {
                    return ($item->product?->price ?? $item->customRequest?->price) * $item->quantity;
                }) - session('discount', 0))
            </span>
        </h5>

        <a href="{{ route('cart.createOrder') }}" class="btn btn-primary">Checkout</a>
    </div>
</div>
@endsection
