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
</style>

<!-- Section-->
<section class="py-5">
<div class="container px-4 px-lg-5 mt-5">
   <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-l-4 justify-content-center">
         @foreach ($data as $i)
            @if ($i->stok > 0)
               <!-- Only display products with stok greater than 0 -->
               <div class="col mb-5">
                     <div class="card h-100">
                        <!-- Product image-->
                        <div class="image-wrapper">
                           <img src="{{ asset('storage/' . $i->gambar) }}" alt="{{ $i->nama }}"
                                 class="img-fluid" />
                        </div>
                        <!-- Product details-->
                        <div class="card-body p-4">
                           <div class="text-center">
                                 <!-- Product name-->
                                 <h5 class="fw-bolder">{{ $i->nama }}</h5>
                                 <p>{{ $i->kategori }}</p>
                                 <!-- Product price-->
                                 <br>
                                 Rp {{ $i->harga }}
                                 <br>
                                 <br>
                                 Stok: {{ $i->stok }}
                           </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                           <div class="text-center">
                                 <!-- Pass the current user and product id using the correct field names -->
                                 <input type="hidden" name="id_user"
                                    value="{{ Auth::check() ? Auth::user()->id : '' }}">
                                 <input type="hidden" name="id_produk" value="{{ $i->id }}">
                                 <!-- This hidden field will be updated by JS with the selected quantity -->
                                 <input type="hidden" name="quantity" value="0" class="buy-quantity">

                                 <!-- Quantity Selector -->
                                 <div class="mb-3 d-flex justify-content-center align-items-center quantity-selector"
                                    data-auth="{{ Auth::check() ? 'true' : 'false' }}">
                                    <button type="button"
                                       class="btn btn-outline-dark decrease-quantity">-</button>
                                    <span id="quantity-{{ $i->id }}"
                                       class="form-control mx-2 text-center quantity-input"
                                       style="width: 100px;">
                                       {{ $i->quantity > 0 ? $i->quantity : 0 }}
                                    </span>
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

   // $(document).ready(function() {
   //       let holdInterval;

   //       function startHoldIncrease($button) {
   //          const $card = $button.closest(".card");
   //          const $quantityElem = $card.find(".quantity-input");
   //          const productId = $button.data("product-id");

   //          holdInterval = setInterval(() => {
   //             let currentQuantity = parseInt($quantityElem.text()) || 0;
   //             let newQuantity = currentQuantity + 1;

   //             $quantityElem.text(newQuantity);
   //             updateCart(productId, newQuantity, "update");
   //          }, 150); // Adjust speed if needed
   //       }

   //       function stopHold() {
   //          clearInterval(holdInterval);
   //       }

   //       $(".increase-quantity").on("mousedown touchstart", function() {
   //          startHoldIncrease($(this));
   //       });

   //       $(document).on("mouseup touchend", stopHold);
   // });


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

   // $(document).ready(function() {
   //       let holdInterval;

   //       function startHold($button, action) {
   //          const $card = $button.closest(".card");
   //          const $quantityElem = $card.find(".quantity-input");
   //          const productId = $card.find('input[name="id_produk"]').val();

   //          holdInterval = setInterval(() => {
   //             let currentQuantity = parseInt($quantityElem.text()) || 0;
   //             let newQuantity = action === "increase" ? currentQuantity + 1 : Math.max(
   //                   currentQuantity - 1, 0);

   //             $quantityElem.text(newQuantity);
   //             updateCart(productId, newQuantity, newQuantity === 0 ? "delete" : "update");
   //          }, 150); // Adjust speed as needed
   //       }

   //       function stopHold() {
   //          clearInterval(holdInterval);
   //       }

   //       $(".increase-quantity").on("mousedown touchstart", function() {
   //          startHold($(this), "increase");
   //       });

   //       $(".decrease-quantity").on("mousedown touchstart", function() {
   //          startHold($(this), "decrease");
   //       });

   //       $(document).on("mouseup touchend", stopHold);
   // });

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
   document.querySelectorAll('.quantity-selector').forEach(selector => {
         selector.addEventListener('click', (e) => {
            if (selector.dataset.auth === 'false') {
               window.location.href = '{{ route('login') }}';
            }
         });
   });
});
</script>
@endsection
