<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Name</title>
</head>
<body>
    <h1>{{ $product->title }}</h1>
    <p>{{ $product->description }}</p>
    <p>Price: ${{ $product->price }}</p>
    <p>Stock: {{ $product->stock }}</p>
    <a href="{{ route('products.index') }}">Back</a>
    <a href="{{ route('cart.create', $product->id) }}"><button>add to cart</button></a>
</body>
</html>