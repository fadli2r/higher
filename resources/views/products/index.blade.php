@extends('layout.template')

@section('styles')
<style>
    body {
        height: 100vh;
        margin: 0;
    }
    main{
        max-width: 1020px;
        margin: auto;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    .product-card {
        margin-bottom: 20px;
    }

    /* Product List */
    .product-list {
        display: flex;
    flex-wrap: wrap;
    gap: 20px;
    flex-direction: row;
    }

    /* Style for Cart Icon */
    #cart-icon {
        position: fixed;
        top: 20px;
        right: 20px;
        font-size: 30px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Hidden Cart Panel */
    #cart {
        display: none; /* Hidden by default */
        position: fixed;
        top: 70px;
        right: 20px;
        width: 300px;
        border: 1px solid #ccc;
        padding: 20px;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #cart h4 {
        margin-bottom: 20px;
    }

    #cart-items {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
    }

    #cart-items li {
        margin-bottom: 10px;
    }

    #cart p {
        font-weight: bold;
    }

    #cart .btn {
        width: 100%;
        margin-top: 10px;
    }
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

.container {
    display: flex;
    padding: 20px;
}

.produk {
    flex: 0 0 80%; /* 60% untuk kolom produk */
    padding-right: 20px;
}

.keranjang {
    flex: 0 0 20%; /* 40% untuk kolom keranjang */
    border-left: 1px solid #ddd;
    padding-left: 20px;
}

h2 {
    margin-bottom: 10px;
}

ul {
    list-style: none;
    margin-bottom: 20px;
    padding-top: 20px;
}

button {
    padding: 10px 15px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

/* Responsif */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .produk, .keranjang {
        flex: 1 0 100%; /* 100% untuk kolom pada layar kecil */
        padding: 0;
        border: none;
    }

    .keranjang {
        border: none;
    }
}
</style>
@endsection

@section('content')

<!-- Shopping Cart Icon -->
<div class="container">
    <div class="produk">
        <h2>Daftar Produk</h2>
        <div class="product-list">
            @foreach ($products as $item)
                <!-- Product Item -->
                <div class="col-md-5">
                    <div class="card product-card" style="width: 18rem;">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Product">
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
    <div class="keranjang">
        <h2>Keranjang Saya</h2>
        <h4>Shopping Cart</h4>
    <ul id="cart-items" class="list-group">
        @foreach ($cart as $item)
        <li class="list-group-item">
            @if ($item->product)
                {{ $item->product->title }} - @rupiah($item->product->price) x {{ $item->quantity }}
            @else
                <em>Produk tidak ditemukan</em>
            @endif
        </li>
    @endforeach
    </ul>
    <p>Items: <span id="total-items">{{ count($cart) }}</span></p>
    <p>Total: Rp.<span id="total-price">
        @rupiah($cart->sum(function ($item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        }))
    </span></p>
        <a href="{{ route('cart.clear') }}">
        <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
    </a>
    <a href="{{ route('cart.index') }}">
        <button class="btn btn-success" id="check-out">Checkout</button>
    </a>
    </div>
</div>
<!-- Shopping Cart Panel -->
<div id="cart">

</div>

@endsection


