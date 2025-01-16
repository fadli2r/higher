@extends('layout.layout')

@section('content')
<div class="cs-height_95 cs-height_lg_70"></div>

<div class="container mt-5">
    <h1 class="text-center">Shopping Cart</h1>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    {{-- <th>Quantity</th> --}}
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cart as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/60' }}"
                                 alt="Item" class="img-thumbnail me-3" style="width: 60px;"> --}}

                            <span>
                                {{ $item->product?->title ?? $item->customRequest?->description }}
                            </span>
                        </div>
                    </td>

                    {{-- <td>
                        <input type="number" class="form-control" value="{{ $item->quantity }}" min="1" disabled>
                    </td> --}}

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
<div class="cs-height_95 cs-height_lg_70"></div>

@endsection
