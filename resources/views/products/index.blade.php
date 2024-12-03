<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List with Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>

<div class="content">
    <h1 class="my-4">Product List</h1>
    <div class="row">
        @foreach ($products as $item)
            <!-- Product Item -->
            <div class="col-md-4">
                <div class="card product-card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ $item->price }}</p>
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
    <p>Total: Rp.<span id="total-price">{{ $cart->sum('product.price') }}</span></p>
    <a href="{{ route('cart.clear') }}">
        <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    $(document).ready(function() {
        let total = 0;

        $('.add-to-cart').click(function() {
            const productName = $(this).data('name');
            const productPrice = parseFloat($(this).data('price'));

            total += productPrice;
            $('#total-price').text(total.toFixed(2));

            $('#cart-items').append(<li class="list-group-item">${productName} - $${productPrice.toFixed(2)}</li>);
        });

        $('#clear-cart').click(function() {
            total = 0;
            $('#cart-items').empty();
            $('#total-price').text(total.toFixed(2));
        });
    });
</script>

</body>
</html>