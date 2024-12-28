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
<h1>Produk dalam Kategori: {{ $category->name }}</h1>

<div class="container">
    <div class="pricing-table">
        @forelse ($products as $product)
        <div class="pricing-card">

            <div class="pricing-body">
                <h3>{{ $product->title }}</h3>
                <p class="price">@rupiah($product->price)</p>
                <div class="description">
                    {!! $product->description !!}
                </div>
            </div>
            <div class="pricing-footer">
                <a href="{{ route('cart.create', $product->id) }}" class="btn">Add to Cart</a>
            </div>
        </div>
        @empty
        <p>Tidak ada produk dalam kategori ini.</p>
        @endforelse
    </div>
</div>

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    h1 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 30px;
        color: #333;
    }

    .pricing-table {
        display: flex; /* Menggunakan Flexbox */
        flex-wrap: wrap; /* Membungkus card ke baris berikutnya */
        gap: 20px; /* Jarak antar card */
        justify-content: center; /* Center-align semua card */
    }

    .pricing-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: calc(33.333% - 20px); /* Membagi card menjadi 3 kolom dengan jarak */
        min-width: 300px; /* Lebar minimum untuk card */
    }

    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .pricing-body {
        padding: 20px;
        text-align: center;
    }

    .pricing-body h3 {
        margin: 10px 0;
        font-size: 1.5rem;
        color: #333;
    }

    .pricing-body .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
        margin: 10px 0;
    }

    .pricing-body .description {
        font-size: 0.9rem;
        color: #666;
        margin: 10px 0;
    }

    .pricing-footer {
        text-align: center;
        padding: 15px;
        background: #f8f8f8;
        border-top: 1px solid #ddd;
    }

    .pricing-footer .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background: #007BFF;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
    }

    .pricing-footer .btn:hover {
        background: #0056b3;
    }
    .description ul {
    list-style: none; /* Hilangkan bullet default */
    padding: 0;
    margin: 0;
}

.description li {
    position: relative;
    padding-left: 30px; /* Beri ruang untuk ikon centang */
    margin-bottom: 10px; /* Beri jarak antar item */
    font-size: 1rem;
    color: #333;
    text-align: left; /* Pastikan teks rata kiri */
}

/* Ikon centang */
.description li::before {
    content: '\2713'; /* Unicode untuk ikon centang */
    position: absolute;
    left: 0; /* Ikon berada di posisi paling kiri */
    top: 50%; /* Pusatkan secara vertikal */
    transform: translateY(-50%); /* Sesuaikan agar tepat di tengah */
    color: #007BFF; /* Warna ikon centang */
    font-size: 1.2rem; /* Ukuran ikon */
}
</style>



<!-- Shopping Cart Icon -->


@endsection
