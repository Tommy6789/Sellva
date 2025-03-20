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

<style>
.product-card {
max-width: 180px;
/* Adjust width */
margin: 0;
/* Center within grid */
}

.image-wrapper {
width: 100%;
height: 150px;
display: flex;
justify-content: center;
align-items: center;
overflow: hidden;
}

.image-wrapper img {
max-height: 100%;
max-width: 100%;
}

.card-body {
padding: 10px;
/* Reduce padding */
font-size: 14px;
/* Reduce text size */
}

#productGrid {
justify-content: flex-start !important;
/* Align items to the left */
}
</style>

<!-- Section-->
<section class="py-5">
<div class="container px-4 px-lg-5 mt-5">
<!-- Tabs Menu -->
<ul class="nav nav-tabs" id="categoryTabs">
      <li class="nav-item">
         <a class="nav-link active" href="#" data-category="all">All</a>
      </li>
      @php
         $validCategories = collect($data)
            ->filter(
                  fn($i) => is_object($i) &&
                     isset($i->stok, $i->expire) &&
                     $i->stok > 0 &&
                     strtotime($i->expire) > time(),
            )
            ->pluck('kategori')
            ->unique();
      @endphp
      @foreach ($validCategories as $category)
         <li class="nav-item">
            <a class="nav-link" href="#" data-category="{{ $category }}">{{ $category }}</a>
         </li>
      @endforeach
</ul>

<!-- Product Grid -->
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-l-4 justify-content-center mt-3"
      id="productGrid">
      @foreach ($data as $i)
         @if ($i->stok > 0 && strtotime($i->expire) > time())
            <div class="col mb-5 product-card" data-category="{{ $i->kategori }}">
                  <div class="card h-100">
                     <div class="image-wrapper">
                        <img src="{{ asset('storage/' . $i->gambar) }}" alt="{{ $i->nama }}"
                              class="img-fluid" />
                     </div>
                     <div class="card-body p-4">
                        <div class="text-center">
                              <h5 class="fw-bolder">{{ $i->nama }}</h5>
                              <p>{{ $i->kategori }}</p>
                              <br>
                              Rp {{ $i->harga }}
                              <br><br>
                              Stok: {{ $i->stok }}
                        </div>
                     </div>
                     <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                              <input type="hidden" name="id_user"
                                 value="{{ Auth::check() ? Auth::user()->id : '' }}">
                              <input type="hidden" name="id_produk" value="{{ $i->id }}">
                              <input type="hidden" name="quantity" value="0" class="buy-quantity">
                              <div class="mb-3 d-flex justify-content-center align-items-center quantity-selector"
                                 data-auth="{{ Auth::check() ? 'true' : 'false' }}">
                                 <button type="button" class="btn btn-outline-dark decrease-quantity">-</button>
                                 <span id="quantity-{{ $i->id }}"
                                    class="form-control mx-2 text-center quantity-input"
                                    style="width: 100px;">{{ $i->quantity > 0 ? $i->quantity : 0 }}</span>
                                 <button type="button" class="btn btn-outline-dark increase-quantity"
                                    data-product-id="{{ $i->id }}">+</button>
                              </div>
                        </div>
                     </div>
                  </div>
            </div>
         @endif
      @endforeach
</div>
</div>
</section>
@endsection

@section('script')
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
         url: "{{ route('keranjang.count') }}", // Adjust this to the route for getting the cart count
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
document.querySelectorAll('.quantity-selector').forEach(selector => {
      selector.addEventListener('click', (e) => {
         if (selector.dataset.auth === 'false') {
            window.location.href = '{{ route('login') }}';
         }
      });
});
});

document.addEventListener("DOMContentLoaded", function() {
const tabs = document.querySelectorAll("#categoryTabs .nav-link");
const products = document.querySelectorAll(".product-card");

tabs.forEach(tab => {
      tab.addEventListener("click", function(e) {
         e.preventDefault();

         tabs.forEach(t => t.classList.remove("active"));
         this.classList.add("active");

         const category = this.getAttribute("data-category");

         products.forEach(product => {
            if (category === "all" || product.getAttribute("data-category") ===
                  category) {
                  product.style.display = "block";
            } else {
                  product.style.display = "none";
            }
         });
      });
});
});
</script>
@endsection
