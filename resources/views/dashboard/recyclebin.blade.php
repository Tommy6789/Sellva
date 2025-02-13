@extends('dashboard.partials.master')

@section('content')

@if (session('success') || session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: "{{ session('success') ? 'success' : 'error' }}",
        title: "{{ session('success') ? 'Berhasil' : 'Gagal' }}",
        text: "{{ session('success') ?? session('error') }}",
    });
</script>
@endif

<!--begin::App Main-->
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Recycle Bin - Data Produk</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Recycle Bin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div>
                <table class="table table-striped">
                    <thead>
                        <th>NO</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tanggal Masuk</th>
                        <th>Expire</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data as $i)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $i->nama }}</td>
                                <td>Rp {{ number_format($i->harga, 0, ',', '.') }}</td>
                                <td>{{ $i->stok }}</td>
                                <td>{{ $i->tanggal_masuk }}</td>
                                <td>{{ $i->expire }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $i->gambar) }}" alt="Produk Gambar"
                                        style="width: 60px; height: 70px;">
                                </td>
                                <td>
                                    <form action="{{ route('dataProduk.restore', $i->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">Restore</button>
                                    </form>
                                
                                    <form action="{{ route('dataProduk.forceDelete', $i->id) }}" method="POST" style="display:inline;" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                                    </form>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@endsection
