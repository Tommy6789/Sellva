<main class="nota-container" id="nota" style="width: 600px; margin: 40px auto; font-family: 'Arial', sans-serif; 
    font-size: 14px; border: 1px solid #ddd; padding: 30px; border-radius: 8px; background-color: #f9f9f9;">
    
    <section id="nota-group" style="width: 600px; margin: 0 auto; font-family: 'Arial', sans-serif; font-size: 14px;">
    
    <!-- Header Section -->
    <section class="text-center mb-5">
        <h2 style="font-weight: 700; color: #333; margin: 0;">Sellva</h2>
        <p style="font-size: 14px; color: #666; margin: 5px 0;">Petugas: <strong>{{ $order->user->name }}</strong></p>
        <p style="font-size: 14px; color: #666; margin: 5px 0;">Waktu Pembayaran: <strong>{{ \Carbon\Carbon::parse($order->waktu_pembayaran)->format('d M Y, H:i') }}</strong></p>
    </section>

    <hr style="border: 1px solid #ddd; margin-bottom: 20px;">

    <!-- Table Section -->
    <section class="table-section">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                <tr style="background-color: #f7f7f7; text-align: left; font-size: 14px; color: #333;">
                    <th style="padding: 12px; text-align: left;">Nama Produk</th>
                    <th style="padding: 12px; text-align: right;">Harga</th>
                    <th style="padding: 12px; text-align: center;">Qty</th>
                    <th style="padding: 12px; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetail as $detail)
                <tr style="border-bottom:2px dashed #ddd;">
                    <td style="padding: 10px 5px; font-size: 14px; color: #333;">{{ $detail->produk->nama }}</td>
                    <td style="padding: 10px 5px; font-size: 14px; color: #333; text-align: right;">Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                    <td style="padding: 10px 5px; font-size: 14px; color: #333; text-align: center;">{{ $detail->quantity }}</td>
                    <td style="padding: 10px 5px; font-size: 14px; color: #333; text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <hr style="border: 1px solid #ddd; margin-bottom: 20px;">

    <!-- Total Section -->
    <section class="total-section" style="text-align: right; font-weight: bold; font-size: 18px; color: #333;">
        <span style="font-size: 16px;">Total: </span> Rp {{ number_format($order->total, 0, ',', '.') }}
    </section>

</section>
</main>

<div style="text-align: center; margin-top: 40px; margin-bottom: 40px;">
    <a class="btn btn-warning" href="{{ route('kasir') }}" style="padding: 12px 25px; font-size: 16px; border-radius: 5px; background-color: #ffc107; color: black; text-decoration: none; border: none;">Kembali</a>
    <button onclick="window.print()" class="btn btn-primary" style="padding: 12px 25px; font-size: 16px; border-radius: 5px; background-color: #007bff; color: white; border: none; cursor: pointer; margin-right: 10px;">Print Nota</button>
</div>


<style>
    /* Hide everything on the page except the nota container during printing */
    @media print {
        body * {
            visibility: hidden;
        }
        #nota, #nota * {
            visibility: visible;
        }
        #nota {
            width: 600px; /* Set maximum width for printing */
            margin: 0 auto; /* Center the nota on the page */
        }
    }
</style>


{{-- @extends('landingPage.partials.master')

@section('content')
<div class="nota-container" style="width: 600px; margin: 40px auto; font-family: 'Arial', sans-serif; 
    font-size: 14px; border: 1px solid #ddd; padding: 30px; border-radius: 8px; background-color: #f9f9f9;">
    
    <div class="text-center mb-5">
        <h2 style="font-weight: 700; color: #333; margin: 0;">Sellva</h2>
        <p style="font-size: 14px; color: #666; margin: 5px 0;">Petugas: <strong>{{ $order->user->name }}</strong></p>
        <p style="font-size: 14px; color: #666; margin: 5px 0;">Waktu Pembayaran: <strong>{{ \Carbon\Carbon::parse($order->waktu_pembayaran)->format('d M Y, H:i') }}</strong></p>
    </div>

    <hr style="border: 1px solid #ddd; margin-bottom: 20px;">

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
        <thead>
            <tr style="background-color: #f7f7f7; text-align: left; font-size: 14px; color: #333;">
                <th style="padding: 12px; text-align: left;">Nama Produk</th>
                <th style="padding: 12px; text-align: right;">Harga</th>
                <th style="padding: 12px; text-align: center;">Qty</th>
                <th style="padding: 12px; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetail as $detail)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px 5px; font-size: 14px; color: #333;">{{ $detail->produk->nama }}</td>
                <td style="padding: 10px 5px; font-size: 14px; color: #333; text-align: right;">Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                <td style="padding: 10px 5px; font-size: 14px; color: #333; text-align: center;">{{ $detail->quantity }}</td>
                <td style="padding: 10px 5px; font-size: 14px; color: #333; text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>



    <div style="text-align: right; font-weight: bold; font-size: 18px; color: #333;">
        <span style="font-size: 16px;">Total: </span> Rp {{ number_format($order->total, 0, ',', '.') }}
    </div>
</div>

<div class="text-center mt-5">
    <button onclick="window.print()" class="btn btn-primary" style="padding: 12px 25px; font-size: 16px; border-radius: 5px; background-color: #007bff; color: white; border: none; cursor: pointer;">Print Nota</button>
</div>

@endsection --}}
