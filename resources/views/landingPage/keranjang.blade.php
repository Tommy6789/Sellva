@extends('landingPage.partials.master')

@section('content')

@if (session('success') || session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '{{ session('success') ? 'success' : 'error' }}',
            title: '{{ session('success') ? 'Berhasil' : 'Gagal' }}',
            text: '{{ session('success') ?? session('error') }}',
        });
    </script>
@endif

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        @if ($data->isEmpty())
            <div class="alert alert-warning text-center">
                Keranjang Anda kosong.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp
                        @foreach ($data as $i)
                            @php
                                $subtotal = $i->quantity * $i->produk->harga;
                                $totalHarga += $subtotal;
                            @endphp
                            <tr id="product-card-{{ $i->produk->id }}">
                                <td>{{ $i->produk->nama }}</td>
                                <td class="price" data-price="{{ $i->produk->harga }}">
                                    Rp {{ number_format($i->produk->harga, 0, ',', '') }}
                                </td>
                                <td>{{ $i->quantity }}</td>
                                <td id="subtotal-{{ $i->produk->id }}">
                                    Rp {{ number_format($subtotal, 0, ',', '') }}
                                </td>
                                <td>
                                    <div class="mb-3 d-flex justify-content-center align-items-center quantity-selector">
                                        <button class="btn btn-outline-dark decrease-quantity" data-product-id="{{ $i->produk->id }}">-</button>
                                        <input type="number" class="form-control mx-2 text-center quantity-input"
                                            value="{{ $i->quantity }}" min="0" style="width: 80px;"
                                            id="quantity-{{ $i->produk->id }}" data-product-id="{{ $i->produk->id }}" readonly>
                                        <button class="btn btn-outline-dark increase-quantity" data-product-id="{{ $i->produk->id }}">+</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total Harga:</td>
                            <td colspan="2" id="total-price">Rp {{ number_format($totalHarga, 0, ',', '') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('keranjangCheckout') }}" class="btn btn-success">Checkout</a>
            </div>
        @endif
    </div>
</section>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        function updateCart(productId, newQuantity, action) {
            let ajaxOptions = {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (newQuantity === 0 && action === "delete") {
                        $(`#product-card-${productId}`).fadeOut("fast", function () {
                            $(this).remove();
                        });
                    }
                    updateCartCount();
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseJSON?.message || "Request failed");
                },
            };

            if (newQuantity === 0) {
                ajaxOptions.url = "{{ route('keranjang.deleteKeranjang') }}";
                ajaxOptions.method = "DELETE";
                ajaxOptions.data = { id_produk: productId };
            } else {
                ajaxOptions.url = "{{ route('keranjang.updateKeranjang') }}";
                ajaxOptions.method = "POST";
                ajaxOptions.data = { id_produk: productId, quantity: newQuantity };
            }

            $.ajax(ajaxOptions);
        }

        function updateCartCount() {
            $.ajax({
                url: "{{ route('keranjang.count') }}",
                method: "GET",
                success: function (response) {
                    $("#cart-count").text(response.count);
                },
                error: function () {
                    console.error("Failed to fetch cart count");
                }
            });
        }

        function updateSubtotal(productId, quantity, price) {
            const subtotal = quantity * price;
            $(`#subtotal-${productId}`).text(`Rp ${subtotal.toLocaleString('id-ID')}`);
        }

        function updateTotalPrice() {
            let total = 0;
            $(".quantity-input").each(function () {
                const productId = $(this).data("product-id");
                const quantity = parseInt($(this).val()) || 0;
                const price = parseFloat($(`#product-card-${productId} .price`).data("price"));
                total += quantity * price;
            });
            $("#total-price").text(`Rp ${total.toLocaleString('id-ID')}`);
        }

        $(".increase-quantity").click(function () {
            const productId = $(this).data("product-id");
            const $quantityElem = $(`#quantity-${productId}`);
            let newQuantity = parseInt($quantityElem.val()) + 1;

            $quantityElem.val(newQuantity);
            updateCart(productId, newQuantity, "update");
            updateSubtotal(productId, newQuantity, parseFloat($(`#product-card-${productId} .price`).data("price")));
            updateTotalPrice();
        });

        $(".decrease-quantity").click(function () {
            const productId = $(this).data("product-id");
            const $quantityElem = $(`#quantity-${productId}`);
            let newQuantity = Math.max(parseInt($quantityElem.val()) - 1, 0);

            $quantityElem.val(newQuantity);
            updateCart(productId, newQuantity, newQuantity === 0 ? "delete" : "update");
            updateSubtotal(productId, newQuantity, parseFloat($(`#product-card-${productId} .price`).data("price")));
            updateTotalPrice();
        });
    });
</script>
@endsection


{{-- @extends('landingPage.partials.master')

@section('content')

@if (session('success') || session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: '{{ session('success') ? 'success' : 'error' }}',
        title: '{{ session('success') ? 'Berhasil' : 'Gagal' }}',
        text: '{{ session('success') ?? session('error') }}',
    });
</script>
@endif

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        @if ($data->isEmpty())
            <div class="alert alert-warning text-center">
                Keranjang Anda kosong.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp

                        @foreach ($data as $i)
                            @php
                                $subtotal = $i->quantity * $i->produk->harga;
                                $totalHarga += $subtotal;
                            @endphp
                            <tr id="product-card-{{ $i->produk->id }}">
                                <td>{{ $i->produk->nama }}</td>
                                <td class="price" data-price="{{ str_replace('.', '', $i->produk->harga) }}">
                                    Rp {{ number_format($i->produk->harga, 0, ',', '.') }}
                                </td>
                                
                                <td>{{ $i->quantity }}</td>
                                <td id="subtotal-{{ $i->produk->id }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td>
                                    <div class="mb-3 d-flex justify-content-center align-items-center quantity-selector">
                                        <!-- Decrease Button -->
                                        <button class="btn btn-outline-dark decrease-quantity" data-product-id="{{ $i->produk->id }}">-</button>
                                        
                                        <!-- Quantity Display -->
                                        <input type="number" class="form-control mx-2 text-center quantity-input" 
                                            value="{{ $i->quantity }}" min="0" style="width: 80px;" 
                                            id="quantity-{{ $i->produk->id }}" data-product-id="{{ $i->produk->id }}" readonly>
                                        
                                        <!-- Increase Button -->
                                        <button class="btn btn-outline-dark increase-quantity" data-product-id="{{ $i->produk->id }}">+</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total Harga:</td>
                            <td colspan="2" id="total-price">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="{{route ('keranjangCheckout')}}" class="btn btn-success">Checkout</a>
            </div>
        @endif
    </div>
</section>
@endsection

@section('script')
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
            ajaxOptions.url = "{{ route('keranjang.deleteKeranjang') }}";
            ajaxOptions.method = "DELETE";
            ajaxOptions.data = { id_produk: productId };
        } else {
            ajaxOptions.url = "{{ route('keranjang.updateKeranjang') }}";
            ajaxOptions.method = "POST";
            ajaxOptions.data = { id_produk: productId, quantity: newQuantity };
        }

        $.ajax(ajaxOptions);
    }

    function updateCartCount() {
        $.ajax({
            url: "{{ route('keranjang.count') }}",
            method: "GET",
            success: function (response) {
                $("#cart-count").text(response.count);
            },
            error: function () {
                console.error("Failed to fetch cart count");
            }
        });
    }

    function updateSubtotal(productId, quantity, price) {
    const cleanPrice = parseFloat(price.toString().replace(/\./g, ''));
    const subtotal = quantity * cleanPrice;
    const formattedSubtotal = `Rp ${subtotal.toLocaleString('id-ID')}`;
    $(`#subtotal-${productId}`).text(formattedSubtotal);
}

function updateTotalPrice() {
    let total = 0;
    $(".quantity-input").each(function () {
        const productId = $(this).data("product-id");
        const quantity = parseInt($(this).val()) || 0;
        let price = $(`#product-card-${productId} .price`).data("price").toString().replace(/\./g, '');
        price = parseFloat(price);
        total += quantity * price;
    });

    const formattedTotal = `Rp ${total.toLocaleString('id-ID')}`;
    $("#total-price").text(formattedTotal);
}

    $(".increase-quantity").click(function () {
        const $card = $(this).closest("tr");
        const $quantityElem = $card.find(".quantity-input");
        const productId = $(this).data("product-id");

        let currentQuantity = parseInt($quantityElem.val()) || 0;
        let newQuantity = currentQuantity + 1;

        $quantityElem.val(newQuantity);
        $card.find("td:nth-child(3)").text(newQuantity);
        updateCart(productId, newQuantity, "update");
        updateSubtotal(productId, newQuantity, let price = $(`#product-card-${productId} .price`).data("price").toString().replace(/\./g, '');
price = parseFloat(price);
);
        updateTotalPrice();
    });

    $(".decrease-quantity").click(function () {
        const $card = $(this).closest("tr");
        const $quantityElem = $card.find(".quantity-input");
        const productId = $(this).data("product-id");

        let currentQuantity = parseInt($quantityElem.val()) || 0;
        let newQuantity = Math.max(currentQuantity - 1, 0);

        $quantityElem.val(newQuantity);
        $card.find("td:nth-child(3)").text(newQuantity);
        updateCart(productId, newQuantity, newQuantity === 0 ? "delete" : "update");
        updateSubtotal(productId, newQuantity, let price = $(`#product-card-${productId} .price`).data("price").toString().replace(/\./g, '');
price = parseFloat(price);
);
        updateTotalPrice();
    });

    $(".quantity-input").change(function () {
        const $card = $(this).closest("tr");
        const productId = $(this).data("product-id");
        const newQuantity = parseInt($(this).val()) || 0;

        $card.find("td:nth-child(3)").text(newQuantity);
        updateCart(productId, newQuantity, newQuantity === 0 ? "delete" : "update");
        updateSubtotal(productId, newQuantity, let price = $(`#product-card-${productId} .price`).data("price").toString().replace(/\./g, '');
price = parseFloat(price);
);
        updateTotalPrice();
    });
    });
</script>

@endsection --}}




{{-- @extends('landingPage.partials.master')

@section('content')

@if (session('success') || session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: '{{ session('success') ? 'success' : 'error' }}',
        title: '{{ session('success') ? 'Berhasil' : 'Gagal' }}',
        text: '{{ session('success') ?? session('error') }}',
    });
</script>
@endif

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        @if ($data->isEmpty())
            <div class="alert alert-warning text-center">
                Keranjang Anda kosong.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp

                        @foreach ($data as $i)
                            @php
                                $subtotal = $i->quantity * $i->produk->harga;
                                $totalHarga += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $i->produk->nama }}</td>
                                <td>Rp {{ number_format($i->produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $i->quantity }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>quantity selector here</tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total Harga:</td>
                            <td colspan="2">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="#" class="btn btn-success">Lanjut ke Checkout</a>
            </div>
        @endif
    </div>
</section>

@endsection --}}
