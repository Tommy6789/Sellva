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
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Order</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashhboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <table class="table table-striped">
                @php $no = 1; @endphp
                <thead>
                    <th>NO</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Nominal Pembayaran</th>
                    <th>Kembalian</th>
                    <th>Waktu Order</th>
                    <th>Waktu Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $order)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $order->total }}</td>
        <td>{{ $order->metode_pembayaran }}</td>
        <td>{{ $order->nominal_pembayaran }}</td>
        <td>{{ $order->kembalian }}</td>
        <td>{{ $order->waktu_order }}</td>
        <td>{{ $order->waktu_pembayaran }}</td>
        <td>{{ $order->status }}</td>
        <td>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailOrder{{ $order->id }}">
                Lihat Detail
            </button>
        </td>
    </tr>

    <!-- Modal for each order -->
    <div class="modal fade" id="detailOrder{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailOrderLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailOrderLabel{{ $order->id }}">Detail Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse ($order->orderDetails as $orderDetail)
                        <div class="mb-3 p-3 border rounded">
                            <strong>Produk:</strong> {{ $orderDetail->produk->nama ?? 'Produk tidak ditemukan' }} <br>
                            <strong>Harga:</strong> Rp {{ number_format($orderDetail->produk->harga ?? 0, 0, ',', '.') }} <br>
                            <strong>Qty:</strong> {{ $orderDetail->quantity }} <br>
                            <strong>Subtotal:</strong> Rp {{ number_format($orderDetail->subtotal, 0, ',', '.') }}
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada detail order.</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection



{{-- @extends('dashboard.partials.master')

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

<!--begin::App Main-->
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Order</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <table class="table table-striped">
                @php $no = 1; @endphp
                <thead>
                    <th>NO</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Nominal Pembayaran</th>
                    <th>Kembalian</th>
                    <th>Waktu Order</th>
                    <th>Waktu Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        <tr>
                            <td>{{ $no++ }} </td>
                            <td>{{ $i->total }} </td>
                            <td>{{ $i->metode_pembayaran }} </td>
                            <td>{{ $i->nominal_pembayaran }} </td>
                            <td>{{$i->kembalian}}</td>
                            <td>{{ $i->waktu_order }} </td>
                            <td>{{ $i->waktu_pembayaran }} </td>
                            <td>{{ $i->status }} </td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailOrder{{ $i->id }}"
                                    >Lihat Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<div class="modal fade" id="detailOrder{{ $i->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailOrderLabel">Detail Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        @foreach ($detail as $i)
                            <tr>
                                <td>{{ $i->produk->nama }}</td>
                                <td>{{ $i->produk->harga }}</td>
                                <td>{{ $i->quantity }}</td>
                                <td>{{ $i->subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection --}}
