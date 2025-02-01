<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" >
        <title>Sellva Homepage</title>
        <!-- Favicon (Browser tab icon) -->
        <link rel="icon" href="{{ asset('assets/SellvaIcon.png') }}" type="image/png">
        <!-- Bootstrap icons-->
        <link href="{{ asset('cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css')}}" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="{{ route('home') }}">Sellva</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('shop') }}">Shop</a></li>

                        {{-- <li class="nav-item"><a class="nav-link" href="#!">About</a></li> --}}
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="{{route('shop')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Keranjang
                            <span id="cart-count" class="badge bg-dark text-white ms-1 rounded-pill">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <script>
            $(document).ready(function () {
            function updateCart(productId, newQuantity, action) {
                let ajaxOptions = {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        console.log(response.message);
                        if (newQuantity === 0 && action === "delete") {
                        // Remove the product card from UI
                        $(`#product-card-${productId}`).fadeOut("fast", function () {
                            $(this).remove();
                        });
                        }
        
                        // Update the cart count dynamically after the action
                        updateCartCount(); 
                    },
                    error: function (xhr) {
                        console.error("Error:", xhr.responseJSON?.message || "Request failed");
                    },
                };
        
                if (newQuantity === 0) {
                    // Delete item from cart
                    ajaxOptions.url = "{{ route('keranjang.deleteKeranjang') }}";
                    ajaxOptions.method = "DELETE";
                    ajaxOptions.data = { id_produk: productId };
                } else {
                    // Update item quantity
                    ajaxOptions.url = "{{ route('keranjang.updateKeranjang') }}";
                    ajaxOptions.method = "POST";
                    ajaxOptions.data = { id_produk: productId, quantity: newQuantity };
                }
        
                $.ajax(ajaxOptions);
            }
        
            function updateCartCount() {
                $.ajax({
                    url: "{{ route('keranjang.count') }}", // This will hit the getCartCount method in your controller
                    method: "GET",
                    success: function (response) {
                        $("#cart-count").text(response.count); // Update the cart count in the header
                    },
                    error: function () {
                        console.error("Failed to fetch cart count");
                    }
                });
            }
        
            // Increase quantity handler
            $(".increase-quantity").click(function () {
                const $card = $(this).closest(".card");
                const $quantityElem = $card.find(".quantity-input");
                const productId = $(this).data("product-id");
        
                let currentQuantity = parseInt($quantityElem.text()) || 0;
                let newQuantity = currentQuantity + 1;
        
                $quantityElem.text(newQuantity);
                updateCart(productId, newQuantity, "update");
            });
        
            // Decrease quantity handler
            $(".decrease-quantity").click(function () {
                const $card = $(this).closest(".card");
                const $quantityElem = $card.find(".quantity-input");
                const productId = $card.find('input[name="id_produk"]').val();
        
                let currentQuantity = parseInt($quantityElem.text()) || 0;
                let newQuantity = Math.max(currentQuantity - 1, 0); // Ensure quantity never goes negative
        
                $quantityElem.text(newQuantity);
                updateCart(productId, newQuantity, newQuantity === 0 ? "delete" : "update");
            });
            });
        </script>
        