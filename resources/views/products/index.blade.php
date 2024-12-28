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


main {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
        font-size: 2rem;
    }

    .category-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .category-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        text-align: center;
        padding: 20px;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .category-card a {
        text-decoration: none;
        color: #333;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .category-card a:hover {
        color: #007BFF;
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
<main>
    <h1>Daftar Kategori</h1>
    <div class="category-list">
        @foreach ($categories as $category)
        <div class="category-card">
            <a href="{{ route('products.category', $category->id) }}">
                <h2>{{ $category->name }}</h2>
            </a>
        </div>
        @endforeach
    </div>
</main>
@endsection



