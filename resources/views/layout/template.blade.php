<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List with Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    @yield('styles')
</head>

<body>
    <header class="header">
        <div class="logo">Logo</div>
        <nav class="menu">
            <ul>
                <li><a href="/my-orders">My Orders</a></li>
                <li>
                    <a href="{{ route('custom-design.index') }}">Custom Desain</a>
                </li>
                <li><a href="/products">Service</a></li>
                @if(auth()->check() && auth()->user()->membership_status === 'member')
    <li><a href="{{ route('promos.index') }}">Promo</a></li>
@endif
            </ul>
        </nav>
        <div class="icons">
            <a href="/admin/edit-profile" >Profile</a>
        </div>
    </header>
      <main>
        @yield('content')  <!-- This is where the page content will be injected -->
      </main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    // Get the cart icon and cart panel
    const cartIcon = document.getElementById('cart-icon');
    const cartPanel = document.getElementById('cart');

    // Toggle visibility of the cart panel when the cart icon is clicked
    cartIcon.addEventListener('click', function() {
        if (cartPanel.style.display === 'none' || cartPanel.style.display === '') {
            cartPanel.style.display = 'block'; // Show the cart panel
        } else {
            cartPanel.style.display = 'none'; // Hide the cart panel
        }
    });
</script>
<script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
