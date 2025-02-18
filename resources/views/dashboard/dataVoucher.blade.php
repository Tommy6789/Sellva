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
            <h3 class="mb-0">Data Voucher</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Voucher</li>
            </ol>
        </div>
    </div>
    <!--end::Row-->
    </div>
    <!--end::Container-->
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Add Voucher Button -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahVoucher">
                Tambah Voucher
            </button>

            <!-- Voucher Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Voucher</th>
                        <th>Jumlah Diskon</th>
                        <th>Syarat</th>
                        <th>Limit</th>
                        <th>Expire</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->nama }}</td>
                            <td>{{ $i->jumlah_diskon }}</td>
                            <td>{{ $i->syarat }}</td>
                            <td>{{ $i->limit }}</td>
                            <td>{{ $i->expire }}</td>
                            <td>
                                <form action="{{ route('dataVoucher.destroy', $i->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this voucher?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editVoucher{{ $i->id }}">Edit</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Tambah Voucher -->
            <div class="modal fade" id="tambahVoucher" tabindex="-1" aria-labelledby="tambahVoucherLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahVoucherLabel">Tambah Voucher</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('dataVoucher.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama">Nama Voucher</label>
                                    <input type="text" class="form-control" name="nama" id="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_diskon">Jumlah Diskon</label>
                                    <input type="text" class="form-control" name="jumlah_diskon" id="jumlah_diskon" required>
                                </div>
                                <div class="mb-3">
                                    <label for="syarat">Syarat</label>
                                    <textarea class="form-control" name="syarat" id="syarat" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="limit">Limit</label>
                                    <input type="number" class="form-control" name="limit" id="limit" required>
                                </div>
                                <div class="mb-3">
                                    <label for="expire">Expire</label>
                                    <input type="date" class="form-control" name="expire" id="expire" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Voucher -->
            @foreach ($data as $i)
                <div class="modal fade" id="editVoucher{{ $i->id }}" tabindex="-1" aria-labelledby="editVoucherLabel{{ $i->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editVoucherLabel{{ $i->id }}">Edit Voucher</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dataVoucher.update', $i->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="nama{{ $i->id }}">Nama Voucher</label>
                                        <input type="text" class="form-control" name="nama" id="nama{{ $i->id }}" value="{{ $i->nama }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_diskon{{ $i->id }}">Jumlah Diskon</label>
                                        <input type="text" class="form-control" name="jumlah_diskon" id="jumlah_diskon{{ $i->id }}" value="{{ $i->jumlah_diskon }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="syarat{{ $i->id }}">Syarat</label>
                                        <textarea class="form-control" name="syarat" id="syarat{{ $i->id }}" rows="3" required>{{ $i->syarat }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="limit{{ $i->id }}">Limit</label>
                                        <input type="number" class="form-control" name="limit" id="limit{{ $i->id }}" value="{{ $i->limit }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expire{{ $i->id }}">Expire</label>
                                        <input type="date" class="form-control" name="expire" id="expire{{ $i->id }}" value="{{ $i->expire }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@endsection
