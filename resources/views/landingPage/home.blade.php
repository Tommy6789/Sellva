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

<!-- Hero Section -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome to Sellva</h1>
            <p class="lead fw-normal text-white-50 mb-0">Your One-Stop Shop for All Your Daily Needs</p>
        </div>
    </div>
</header>

{{-- <!-- Featured Products Section (Placeholder) -->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">Featured Products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
            @for($i = 1; $i <= 8; $i++)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Placeholder image-->
                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="Product Image">
                    <!-- Placeholder details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">Sample Product {{ $i }}</h5>
                            <p class="text-muted">Rp {{ number_format(rand(10000, 100000), 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <!-- Placeholder action-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View Details</a></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Categories Section (Placeholder) -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">Browse by Categories</h2>
        <div class="row gx-4 gx-lg-5">
            @for($i = 1; $i <= 3; $i++)
            <div class="col-md-4 mb-5">
                <div class="card">
                    <img class="card-img-top" src="https://dummyimage.com/600x400/ced4da/6c757d.jpg" alt="Category Image">
                    <div class="card-body">
                        <h5 class="card-title">Category {{ $i }}</h5>
                        <p class="card-text">Explore our collection of products in this category.</p>
                        <a href="#" class="btn btn-primary">Explore</a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section> --}}

<!-- Testimonials Section (Placeholder) -->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4 text-center">What Our Customers Say</h2>
        <div class="row">
            @for($i = 1; $i <= 3; $i++)
            <div class="col-md-4 mb-4">
                <div class="testimonial bg-light p-4">
                    <p>"Sample testimonial {{ $i }}. Great shopping experience!"</p>
                    <div class="d-flex align-items-center mt-3">
                        <img class="rounded-circle me-3" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="Customer Image">
                        <div>
                            <strong>Customer {{ $i }}</strong>
                            <span class="text-muted">Customer</span>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

@endsection
