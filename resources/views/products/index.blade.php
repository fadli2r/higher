@extends('layout.template')

@section('styles')
<style>
    body {
        display: flex;
        height: 100vh;
        overflow: hidden;
    }
    .content {
        margin-left: 250px;
        padding: 20px;
        width: calc(100% - 250px);
        overflow-y: auto;
    }
    .product-card {
        margin-bottom: 20px;
    }
    #cart {
        position: fixed;
        top: 70px;
        right: 20px;
        width: 300px;
        border: 1px solid #ccc;
        padding: 10px;
        background: #fff;
    }
</style>
@endsection

@section('content')
<div class="content">
    <h1 class="my-4">Product List</h1>
    <div class="row">
        @foreach ($products as $item)
            <!-- Product Item -->
            <div class="col-md-4">
                <div class="card product-card">
                    <img src="https://via.placeholder.com/150" class="card-img-top w-50" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">@rupiah($item->price)</p>
                        <a href="{{ route('cart.create', $item->id) }}">
                            <button class="btn btn-primary">Add to Cart</button>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="cart">
    <h4>Shopping Cart</h4>
    <ul id="cart-items" class="list-group"></ul>
    <p>Item(s): <span id="total-price">{{ sizeOf($cart) }}</span></p>
    <p>Total: Rp.<span id="total-price">@rupiah($cart->sum('product.price'))</span></p>
    <a href="{{ route('cart.clear') }}">
        <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
    </a>
    <a href="{{ route('cart.index') }}">
        <button class="btn btn-success" id="clear-cart">Check Out</button>
    </a>
</div>
@endsection