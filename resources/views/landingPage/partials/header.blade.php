<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sellva Homepage</title>
    <!-- Favicon (Browser tab icon) -->
    <link rel="icon" href="{{ asset('assets/SellvaIcon.png') }}" type="image/png">
    <!-- Bootstrap icons-->
    <link href="{{ asset('cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="{{ route('home') }}">Sellva</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('shop') }}">Shop</a></li>
    
                    @auth
                        @if (Auth::user()->role === 'kasir')
                            <li class="nav-item"><a class="nav-link" href="{{ route('kasir') }}">Kasir</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('dataProduk.index') }}">Data Produk</a></li>
                            @endif
                            @if (Auth::user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('kasir') }}">Kasir</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        @endif
                    @endauth
    
                    <li class="nav-item">
                        @auth
                            <a class="nav-link active" href="#" id="logout-btn">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.getElementById("logout-btn").addEventListener("click", function(event) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: "Are you sure?",
                                        text: "You will be logged out!",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        cancelButtonColor: "#3085d6",
                                        confirmButtonText: "Yes, logout!"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById("logout-form").submit();
                                        }
                                    });
                                });
                            </script>
                        @else
                            <a class="nav-link active" href="{{ route('login') }}">Login</a>
                        @endauth
                    </li>
                </ul>

                        <a href="{{ route('keranjangPage') }}" class="btn btn-outline-dark d-flex align-items-center">
                            <i class="bi-cart-fill me-1"></i>
                            Keranjang
                            <span id="cart-count" class="badge bg-dark text-white ms-1 rounded-pill">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </a>
            </div>
        </div>
    </nav>
    
    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Sellva</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page"
                            href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item">
                        @if (Auth::check())
                            <a class="nav-link active" aria-current="page" href="{{ route('shop') }}">Shop</a>
                        @else
                            <a class="nav-link active" aria-current="page" href="{{ route('login') }}"
                                onclick="event.preventDefault(); window.location.href='{{ route('login') }}';">Shop</a>
                        @endif
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kasir') }}">Kasir</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        @if (Auth::check())
                            <a class="nav-link active" href="#" id="logout-btn">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.getElementById("logout-btn").addEventListener("click", function(event) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: "Are you sure?",
                                        text: "You will be logged out!",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        cancelButtonColor: "#3085d6",
                                        confirmButtonText: "Yes, logout!"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById("logout-form").submit();
                                        }
                                    });
                                });
                            </script>
                        @else
                            <a class="nav-link active" href="{{ route('login') }}">Login</a>
                        @endif
                    </li>
                </ul>
                <a href="{{ route('keranjangPage') }}" class="btn btn-outline-dark d-flex align-items-center">
                    <i class="bi-cart-fill me-1"></i>
                    Keranjang
                    <span id="cart-count" class="badge bg-dark text-white ms-1 rounded-pill">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>
            </div>
        </div>
    </nav> --}}

    <script>
        $(document).ready(function() {
            function updateCart(productId, newQuantity, action) {
                let ajaxOptions = {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        console.log(response.message);
                        if (newQuantity === 0 && action === "delete") {
                            // Remove the product card from UI
                            $(`#product-card-${productId}`).fadeOut("fast", function() {
                                $(this).remove();
                            });
                        }

                        // Update the cart count dynamically after the action
                        updateCartCount();
                    },
                    error: function(xhr) {
                        console.error("Error:", xhr.responseJSON?.message || "Request failed");
                    },
                };

                if (newQuantity === 0) {
                    // Delete item from cart
                    ajaxOptions.url = "{{ route('keranjang.deleteKeranjang') }}";
                    ajaxOptions.method = "DELETE";
                    ajaxOptions.data = {
                        id_produk: productId
                    };
                } else {
                    // Update item quantity
                    ajaxOptions.url = "{{ route('keranjang.updateKeranjang') }}";
                    ajaxOptions.method = "POST";
                    ajaxOptions.data = {
                        id_produk: productId,
                        quantity: newQuantity
                    };
                }

                $.ajax(ajaxOptions);
            }

            function updateCartCount() {
                $.ajax({
                    url: "{{ route('keranjang.count') }}", // This will hit the getCartCount method in your controller
                    method: "GET",
                    success: function(response) {
                        $("#cart-count").text(response.count); // Update the cart count in the header
                    },
                    error: function() {
                        console.error("Failed to fetch cart count");
                    }
                });
            }

            // Increase quantity handler
            $(".increase-quantity").click(function() {
                const $card = $(this).closest(".card");
                const $quantityElem = $card.find(".quantity-input");
                const productId = $(this).data("product-id");

                let currentQuantity = parseInt($quantityElem.text()) || 0;
                let newQuantity = currentQuantity + 1;

                $quantityElem.text(newQuantity);
                updateCart(productId, newQuantity, "update");
            });

            // Decrease quantity handler
            $(".decrease-quantity").click(function() {
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
