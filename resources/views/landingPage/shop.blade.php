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
   max-width: 150px;
   /* Sets a fixed maximum width of 180px */
   margin: 0;
   /* Ensures there is no extra margin (typically centers it in the grid) */
}

.image-wrapper {
   width: 100%;
   /* Makes the wrapper take full width of the card */
   height: 150px;
   /* Fixes a height of 150px */
   display: flex;
   justify-content: center;
   /* Centers the image horizontally */
   align-items: center;
   /* Centers the image vertically */
   overflow: hidden;
   /* Prevents overflow (if the image is too large) */
}

.image-wrapper img {
   max-height: 100%;
   /* Ensures the image never exceeds the wrapper height */
   max-width: 100%;
   /* Ensures the image never exceeds the wrapper width */
}

.card-body {
   padding: 10px;
   /* Reduces padding inside the card */
   font-size: 14px;
   /* Decreases text size for better fit */
}

/* Mengurangi margin atau padding yang mungkin menyebabkan jarak */
.nav-tabs {
   margin-top: 0 !important;
   padding-top: 0 !important;
}

/* Menghapus padding pada section jika perlu */
section.py-5 {
   padding-top: 10px !important;
   /* Sesuaikan angka sesuai kebutuhan */
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
               ->filter(function ($i) {
                     return is_object($i) &&
                        isset($i->stok, $i->expire, $i->kategori) &&
                        $i->stok > 0 &&
                        (!empty($i->expire) && strtotime($i->expire) > time());
               })
               ->pluck('kategori')
               ->unique();

            // Ensure "Peralatan Rumah Tangga" is always included
            if (!$validCategories->contains('Peralatan Rumah Tangga')) {
               $validCategories->push('Peralatan Rumah Tangga');
            }
         @endphp

         @foreach ($validCategories as $category)
            <li class="nav-item">
               <a class="nav-link" href="#" data-category="{{ $category }}">{{ $category }}</a>
            </li>
         @endforeach
   </ul>
   <br>
   <!-- Product Grid -->
   <div class="row gx-4 gx-lg-3 row-cols-2 row-cols-md-3 row-cols-lg-3" id="productGrid">
         @foreach ($data as $i)
            @if ($i->kategori == 'Peralatan Rumah Tangga' || strtotime($i->expire) > time())
               <div class="col mb-5 product-card" data-category="{{ $i->kategori }}">
                     <div class="card h-100">
                        <div class="image-wrapper">
                           <img src="{{ asset('storage/' . $i->gambar) }}" alt="{{ $i->nama }}"
                                 class="img-fluid" />
                        </div>
                        <div class="card-body p-2">
                           <div class="text-center">
                                 <h5 class="fw-bolder">{{ $i->nama }}</h5>
                                 <p>{{ $i->kategori }}</p>
                                 <p>RP {{ number_format($i->harga, 0, ',', '.') }}</p>
                                 <p>Stok: {{ $i->stok }}</p>
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
                                    <button type="button"
                                       class="btn btn-outline-dark decrease-quantity">-</button>
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
   // Menjalankan skrip setelah dokumen selesai dimuat

   function updateCart(productId, newQuantity, action) {
         // Fungsi untuk memperbarui jumlah produk di keranjang atau menghapus produk jika jumlahnya 0

         let ajaxOptions = {
            headers: {
               "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
               // Menambahkan CSRF token untuk keamanan request AJAX
            },
            success: function(response) {
               console.log(response.message);
               // Menampilkan pesan sukses di console

               if (newQuantity === 0 && action === "delete") {
                     // Jika jumlah produk 0 dan aksi adalah delete, hapus elemen produk dari tampilan
                     $(`#product-card-${productId}`).fadeOut("fast", function() {
                        $(this).remove();
                     });
               }

               updateCartCount();
               // Memperbarui jumlah produk di ikon keranjang setelah perubahan dilakukan
            },
            error: function(xhr) {
               console.error("Error:", xhr.responseJSON?.message || "Request failed");
               // Menampilkan pesan error jika request gagal
            },
         };

         if (newQuantity === 0) {
            // Jika jumlah produk 0, kirim request DELETE untuk menghapus produk dari keranjang
            ajaxOptions.url = "{{ route('keranjang.deleteKeranjang') }}";
            ajaxOptions.method = "DELETE";
            ajaxOptions.data = {
               id_produk: productId
            };
         } else {
            // Jika jumlah produk lebih dari 0, kirim request POST untuk memperbarui jumlahnya
            ajaxOptions.url = "{{ route('keranjang.updateKeranjang') }}";
            ajaxOptions.method = "POST";
            ajaxOptions.data = {
               id_produk: productId,
               quantity: newQuantity
            };
         }

         $.ajax(ajaxOptions);
         // Mengirim request AJAX sesuai dengan kondisi di atas
   }

   function updateCartCount() {
         // Fungsi untuk memperbarui jumlah produk yang ditampilkan di ikon keranjang

         $.ajax({
            url: "{{ route('keranjang.count') }}", // Mengambil jumlah item di keranjang dari server
            method: "GET",
            success: function(response) {
               $("#cart-count").text(response.count);
               // Menampilkan jumlah item di elemen dengan id "cart-count"
            },
            error: function() {
               console.error("Failed to fetch cart count");
               // Menampilkan error jika request gagal
            }
         });
   }

   // Event handler untuk menambah jumlah produk
   $(".increase-quantity").click(function() {
         const $card = $(this).closest(".card");
         // Mendapatkan elemen kartu produk terkait

         const $quantityElem = $card.find(".quantity-input");
         // Mendapatkan elemen yang menampilkan jumlah produk

         const productId = $(this).data("product-id");
         // Mengambil ID produk dari atribut data-product-id

         let currentQuantity = parseInt($quantityElem.text()) || 0;
         // Mengambil jumlah produk saat ini (jika kosong, default ke 0)

         let newQuantity = currentQuantity + 1;
         // Menambah jumlah produk

         $quantityElem.text(newQuantity);
         // Memperbarui tampilan jumlah produk

         updateCart(productId, newQuantity, "update");
         // Memanggil fungsi untuk memperbarui jumlah di server
   });

   // Event handler untuk mengurangi jumlah produk
   $(".decrease-quantity").click(function() {
         const $card = $(this).closest(".card");
         const $quantityElem = $card.find(".quantity-input");
         const productId = $card.find('input[name="id_produk"]').val();

         let currentQuantity = parseInt($quantityElem.text()) || 0;
         let newQuantity = Math.max(currentQuantity - 1, 0);
         // Mengurangi jumlah produk, tetapi tidak boleh kurang dari 0

         $quantityElem.text(newQuantity);
         // Memperbarui tampilan jumlah produk

         updateCart(productId, newQuantity, newQuantity === 0 ? "delete" : "update");
         // Jika jumlah produk 0, hapus produk dari keranjang, jika tidak, perbarui jumlahnya
   });

   // Event handler untuk pengguna yang belum login
   document.querySelectorAll('.quantity-selector').forEach(selector => {
         selector.addEventListener('click', (e) => {
            if (selector.dataset.auth === 'false') {
               // Jika pengguna belum login, arahkan ke halaman login
               window.location.href = '{{ route('login') }}';
            }
         });
   });
});

// Event handler untuk filter kategori produk
document.addEventListener("DOMContentLoaded", function() {
   const tabs = document.querySelectorAll("#categoryTabs .nav-link");
   // Mengambil semua tab kategori

   const products = document.querySelectorAll(".product-card");
   // Mengambil semua elemen produk

   tabs.forEach(tab => {
         tab.addEventListener("click", function(e) {
            e.preventDefault();
            // Mencegah perubahan URL saat mengklik tab

            tabs.forEach(t => t.classList.remove("active"));
            // Menghapus class active dari semua tab

            this.classList.add("active");
            // Menambahkan class active pada tab yang diklik

            const category = this.getAttribute("data-category");
            // Mengambil kategori yang dipilih

            products.forEach(product => {
               if (category === "all" || product.getAttribute("data-category") ===
                     category) {
                     product.style.display = "block";
                     // Menampilkan produk jika sesuai dengan kategori yang dipilih
               } else {
                     product.style.display = "none";
                     // Menyembunyikan produk yang tidak sesuai
               }
            });
         });
   });
});
</script>
@endsection
