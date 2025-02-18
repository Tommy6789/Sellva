@extends('dashboard.partials.master')

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

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Dashhboard</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <!-- Total Users -->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-primary">
            <div class="inner">
              <h3>{{ $totalUsers }}</h3>
              <p>Total Users</p>
            </div>
            <i class="bi bi-person-circle small-box-icon"></i>
            <a href="{{ route('dataUsers') }}" class="small-box-footer">
              More info <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>

        <!-- Total Products -->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-success">
            <div class="inner">
              <h3>{{ $totalProducts }}</h3>
              <p>Total Products</p>
            </div>
            <i class="bi bi-box-seam small-box-icon"></i>
            <a href="{{ route('dataProduk.index') }}" class="small-box-footer">
              More info <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>

        <!-- Total Orders -->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-warning">
            <div class="inner">
              <h3>{{ $totalOrders }}</h3>
              <p>Total Orders</p>
            </div>
            <i class="bi bi-receipt small-box-icon"></i>
            <a href="{{route('dataOrder')}}" class="small-box-footer">
              More info <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>

        {{-- <!-- Total Cart Items -->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-danger">
            <div class="inner">
              <h3>{{ $totalCartItems }}</h3>
              <p>Total Cart Items</p>
            </div>
            <i class="bi bi-cart small-box-icon"></i>
            <a href="#" class="small-box-footer">
              More info <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div> --}}

      <!-- Additional Section: Recent Orders -->
      <div class="row mt-5">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recent Orders</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Order Time</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentOrders as $order)
                  <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                      <span class="badge bg-{{ $order->status == 'proses' ? 'warning' : 'success' }}">
                        {{ ucfirst($order->status) }}
                      </span>
                    </td>
                    <td>{{ $order->waktu_order }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection