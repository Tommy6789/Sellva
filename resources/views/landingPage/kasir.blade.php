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
         <h2 class="mb-4">Daftar Pesanan</h2>

         @if ($data->isEmpty())
            <div class="alert alert-warning text-center">
               Belum ada pesanan.
            </div>
         @else
            <div class="table-responsive">
               <table class="table table-bordered">
                     <thead class="table-dark">
                        <tr>
                           <th>ID Pesanan</th>
                           <th>Waktu Order</th>
                           <th>Waktu Pembayaran</th>
                           <th>Total</th>
                           <th>Nominal Pembayaran</th>
                           <th>Kembalian</th>
                           <th>Status</th>
                           <th>Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($data as $order)
                           <tr>
                                 <td>{{ $order->id }}</td>
                                 <td>{{ $order->waktu_order }}</td>
                                 <td>{{ $order->waktu_pembayaran }}</td>
                                 <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                 <td>Rp {{ number_format($order->nominal_pembayaran, 0, ',', '.') }}</td>
                                 <td>Rp {{ number_format($order->kembalian, 0, ',', '.') }}</td>
                                 <td>{{ ucfirst($order->status) }}</td>
                                 <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                       data-bs-target="#modalPembayaran{{ $order->id }}">Pembayaran</button>
                                 </td>
                           </tr>

                           <!-- Modal Pembayaran -->
                           <div class="modal fade" id="modalPembayaran{{ $order->id }}" tabindex="-1"
                                 aria-labelledby="modalPembayaranLabel{{ $order->id }}" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <form action="{{ route('pembayaran', $order->id) }}" method="POST">
                                             @csrf
                                             <div class="modal-header">
                                                <h5 class="modal-title">Pembayaran</h5>
                                                <button type="button" class="btn-close"
                                                   data-bs-dismiss="modal"></button>
                                             </div>
                                             <div class="modal-body">
                                                <div class="mb-3">
                                                   <label for="metode_pembayaran">Metode Pembayaran</label>
                                                   <select name="metode_pembayaran" class="form-control"
                                                         required>
                                                      <option value="">Pilih Metode Pembayaran ↓</option>
                                                      <option value="tunai">Tunai</option>
                                                      <option value="debit">Debit</option>
                                                      <option value="kredit">Kredit</option>
                                                      <option value="qris">QRIS</option>
                                                   </select>
                                                </div>
                                                <div class="mb-3">
                                                   <label for="nominal_pembayaran">Nominal Pembayaran</label>
                                                   <input type="text" class="form-control nominal_pembayaran"
                                                         name="nominal_pembayaran"
                                                         data-total="{{ $order->total }}"
                                                         placeholder="Masukkan nominal pembayaran (contoh: 10000)"
                                                         required>
                                                </div>
                                                <div class="mb-3">
                                                   <label for="kembalian">Kembalian</label>
                                                   <input type="text" class="form-control kembalian" readonly>
                                                </div>
                                             </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                   data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                             </div>
                                       </form>
                                    </div>
                                 </div>
                           </div>

                           <!-- End Modal Pembayaran -->
                        @endforeach
                     </tbody>
               </table>
            </div>
         @endif
   </div>
</section>
@endsection

@section('script')
<script>
   $(document).ready(function() {
      $(document).on('input', '.nominal_pembayaran', function() {
         let total = parseFloat($(this).data('total'));
         let pembayaran = parseFloat($(this).val().replace(/\./g, '')) || 0; // Clean value by removing dot separator
         let kembalian = Math.max(pembayaran - total, 0);

         // Display the cleaned value without any dot separators
         $(this).val(pembayaran.toLocaleString('id-ID')); // Formatting for display
         $(this).closest('.modal-body').find('.kembalian').val(kembalian.toLocaleString('id-ID'));
      });
   });
</script>
@endsection


      {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
      $(document).on('input', '.nominal_pembayaran', function() {
      let total = parseFloat($(this).data('total'));  // Get the total from the data attribute
      let pembayaran = parseFloat($(this).val());     // Get the input value for nominal pembayaran
      let kembalian = pembayaran > total ? pembayaran - total : 0;  // Calculate kembalian (change)

      // Find the associated kembalian input and update its value
      $(this).closest('.modal-body').find('.kembalian').val(kembalian);
      });
      </script> --}}



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
      <h2 class="mb-4">Daftar Pesanan</h2>

      @if ($data->isEmpty())
      <div class="alert alert-warning text-center">
         Belum ada pesanan.
      </div>
      @else
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead class="table-dark">
                  <tr>
                     <th>ID Pesanan</th>
                     <th>Tanggal Pembelian</th>
                     <th>Total</th>
                     <th>Status</th>
                     <th>Aksi</th>
                  </tr>
            </thead>
            <tbody>
                  @foreach ($data as $order)
                     <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->tanggal_pembelian }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                              <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                 data-bs-target="#modalPembayaran{{ $order->id }}">Pembayaran</button>
                        </td>
                     </tr>
                  @endforeach
            </tbody>
         </table>
      </div>
      @endif
      </div>
      <!-- Modal Pembayaran -->
      <div class="modal fade" data-bs-backdrop="static" id="modalPembayaran{{ $order->id }}" tabindex="-1"
      aria-labelledby="modalPembayaranLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalPembayaranLabel">Pembayaram</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{route('pembayaran', $order->id)}}">
                  @csrf
                  @method('PUT')
                  <label for="nominal_pembayaran">Nominal Pembayaran</label>
                  <input type="number" class="form-control" name="nominal_pembayaran">
                  <label for="kembalian">Kembalian</label>
                  <input type="number" class="form-control" name="kembalian" readonly>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div>
      </div>
      </div>
      <!-- End Modal Pembayaran -->
      </section>
      @endsection

      @section('script')
      @endsection --}}
