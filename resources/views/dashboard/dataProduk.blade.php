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

<!--begin::App Main-->
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
<!--begin::Container-->
<div class="container-fluid">
<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Data Produk</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashhboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Produk</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#tambahProduk">Tambah Produk</button>
            <a href="{{ route('recyclebin') }}" class="btn btn-success">Recycle Bin</a>
            <br>
        </div>

        <!-- Active Products Table -->
        <div class="my-4">
            <h3 style="color: green">Active Products</h3>
            <table class="table table-striped">
                @php $no = 1; @endphp
                <thead>
                    <th>NO</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Tanggal Masuk</th>
                    <th>Expire</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        @if (strtotime($i->expire) > time())
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $i->nama }}</td>
                                <td>{{ $i->kategori }}</td>
                                <td>Rp {{ number_format($i->harga, 0, ',', '.') }}</td>
                                <td>{{ $i->stok }}</td>
                                <td>{{ $i->tanggal_masuk }}</td>
                                <td>{{ date('d-m-Y', strtotime($i->expire)) }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $i->gambar) }}" alt="Produk Gambar"
                                        style="width: 60px; height: 70px;">
                                </td>
                                <td>
                                    <form action="{{ route('softDeleteProduk', $i->id) }}" method="POST" style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editProduk{{ $i->id }}">Edit</button>
                                        <!-- Delete Button -->
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Expired Products Table -->
        <div class="my-4">
            <h3 style="color: red">Expired Products</h3>
            <table class="table table-striped">
                @php $no = 1; @endphp
                <thead>
                    <th>NO</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Tanggal Masuk</th>
                    <th>Expire</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        @if (strtotime($i->expire) <= time())
                            <tr class="table-danger">
                                <td>{{ $no++ }}</td>
                                <td>{{ $i->nama }}</td>
                                <td>{{ $i->kategori }}</td>
                                <td>Rp {{ number_format($i->harga, 0, ',', '.') }}</td>
                                <td>{{ $i->stok }}</td>
                                <td>{{ $i->tanggal_masuk }}</td>
                                <td>{{ date('d-m-Y', strtotime($i->expire)) }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $i->gambar) }}" alt="Produk Gambar"
                                        style="width: 60px; height: 70px;">
                                </td>
                                <td>
                                    <form action="{{ route('softDeleteProduk', $i->id) }}" method="POST" style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this expired product?');">
                                        @csrf
                                        @method('DELETE')
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editProduk{{ $i->id }}">Edit</button>
                                        <!-- Delete Button -->
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--end::Container-->
</div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="tambahProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahProdukLabel">Tambah Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dataProduk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" class="form-control" name="nama" id="nama">
                    <br>
                    <label for="kategori">Kategori</label><label for="kategori"></label>
                    <select class="form-control" name="kategori" id="">
                        <option value="">Pilih Kategori ↓</option>
                        <option value="Makanan Siap Saji">Makanan</option>
                        <option value="Snack">Snack</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Makanan Instan">Makanan Instan</option>
                        <option value="Minuman Instan">Minuman Instan</option>
                        <option value="Produk Rumah Tangga">Produk Rumah Tangga</option>
                    </select>
                    <br>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" id="harga">
                    <br>
                    <label for="stok">Stok</label>
                    <input type="text" class="form-control" name="stok" id="stok">
                    <br>
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk">
                    <br>
                    <label for="stok">expire</label>
                    <input type="date" class="form-control" name="expire" id="expire">
                    <br>
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control" name="gambar" id="gambar">
                    <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Konfirmasi</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Tambah Produk -->

<!-- Modal Edit Produk -->
@foreach ($data as $i)
    <div class="modal fade" id="editProduk{{ $i->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="editProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editProdukLabel">Edit Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dataProduk.update', $i->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ $i->nama }}">
                        <br>
                        <label for="kategori">Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                            <option value="">Pilih Kategori ↓</option>
                            <option value="Makanan Siap Saji" {{ $i->kategori == "Makanan Siap Saji" ? 'selected' : '' }}>Makanan</option>
                            <option value="Snack" {{ $i->kategori == "Snack" ? 'selected' : '' }}>Snack</option>
                            <option value="Minuman" {{ $i->kategori == "Minuman" ? 'selected' : '' }}>Minuman</option>
                            <option value="Makanan Instan" {{ $i->kategori == "Makanan Instan" ? 'selected' : '' }}>Makanan Instan</option>
                            <option value="Minuman Instan" {{ $i->kategori == "Minuman Instan" ? 'selected' : '' }}>Minuman Instan</option>
                            <option value="Produk Rumah Tangga" {{ $i->kategori == "Produk Rumah Tangga" ? 'selected' : '' }}>Produk Rumah Tangga</option>
                        </select>
                        
                        <br>
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga" value="{{ $i->harga }}">
                        <br>
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" name="stok" id="stok" value="{{ $i->stok }}">
                        <br>
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{ $i->tanggal_masuk }}">
                        <br>
                        <label for="stok">expire</label>
                        <input type="date" class="form-control" name="expire" id="expire" value="{{ $i->expire }}">
                        <br>
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar">
                        <!-- Show the current image if it exists -->
                        @if ($i->gambar)
                            <small>Current Image: <a href="{{ asset('storage/' . $i->gambar) }}" target="_blank">View</a></small>
                        @endif
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<!-- End Modal Edit Produk -->
</main>
<!--end::App Main-->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@endsection
