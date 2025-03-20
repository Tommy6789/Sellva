<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\order;
use App\Models\orderDetail;
use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function home()
    {
        return view('landingPage.home');
    }

    public function shop()
    {
        // $data = produk::all();
            $data = DB::table('produks')
                ->Leftjoin('keranjangs', 'produks.id', '=', 'keranjangs.id_produk')
                ->select('produks.*', 'keranjangs.quantity')
                ->get();
        return view('landingPage.shop', compact('data'));
    }

    // public function shop()
    // {
    //     // $data = produk::all();
    //     if (Auth::check()) {
    //         $data = DB::table('produks')
    //             ->Leftjoin('keranjangs', 'produks.id', '=', 'keranjangs.id_produk')
    //             ->select('produks.*', 'keranjangs.quantity')
    //             ->get();
    //     } else {
    //         $data = produk::paginate(6);
    //     }
    //     return view('landingPage.shop', compact('data'));
    // }

    public function kasir()
{
    // Fetch all orders and sort by 'waktu_order' in descending order
    $data = Order::orderBy('waktu_order', 'desc')->get();

    // Return the data to the view
    return view('landingPage.kasir', compact('data'));
}

    public function  pembayaran(Request $request, $id)
    {
        // Clean the nominal_pembayaran to remove thousand separators
        $nominalPembayaran = str_replace('.', '', $request->nominal_pembayaran);
    
        // Validate the input
        $validatedData = $request->validate([
            'metode_pembayaran' => 'required',
            'nominal_pembayaran' => 'required|numeric|min:0',
        ]);
    
        // Now we can safely use the cleaned value
        $validatedData['nominal_pembayaran'] = (int)$nominalPembayaran;
    
        $order = Order::findOrFail($id);
    
        // Calculate 'kembalian'
        $total = $order->total;
        $kembalian = $validatedData['nominal_pembayaran'] - $total;
    
        // Update the order with the payment details
        $order->update([
            'metode_pembayaran' => $validatedData['metode_pembayaran'],
            'nominal_pembayaran' => $validatedData['nominal_pembayaran'],
            'kembalian' => $kembalian,
            'waktu_pembayaran' => now(),
            'status' => 'selesai',
        ]);
    
        $kurangiStok = orderDetail::where('id_order', $id)->get();
        foreach ($kurangiStok as $item) {
            $produk = produk::where('id', $item->id_produk)->first();
            $stok = $produk->stok;
            $kurangistok = $stok - $item->quantity;
            $updateStok = produk::where('id', $item->id_produk)->update(['stok' => $kurangistok]);
        }
    
        // Clear the cart after successful payment
        Keranjang::where('id_user', $order->id_user)->delete();
    
        return redirect()->back()->with('success', 'Pembayaran berhasil.');
    }

    // public function pembayaran(Request $request, $id)
    // {
    //     // Clean the nominal_pembayaran to remove thousand separators
    //     $nominalPembayaran = str_replace('.', '', $request->nominal_pembayaran);
    
    //     // Validate the input
    //     $validatedData = $request->validate([
    //         'metode_pembayaran' => 'required',
    //         'nominal_pembayaran' => 'required|numeric|min:0',
    //     ]);
    
    //     // Now we can safely use the cleaned value
    //     $validatedData['nominal_pembayaran'] = (int)$nominalPembayaran;
    
    //     $order = Order::findOrFail($id);
    
    //     // Calculate 'kembalian'
    //     $total = $order->total;
    //     $kembalian = $validatedData['nominal_pembayaran'] - $total;
    
    //     // Update the order with the payment details
    //     $order->update([
    //         'metode_pembayaran' => $validatedData['metode_pembayaran'],
    //         'nominal_pembayaran' => $validatedData['nominal_pembayaran'],
    //         'kembalian' => $kembalian,
    //         'waktu_pembayaran' => now(),
    //         'status' => 'selesai',
    //     ]);
    
    //     $kurangiStok = orderDetail::where('id_order', $id)->get();
    //     foreach ($kurangiStok as $item) {
    //         $produk = produk::where('id', $item->id_produk)->first();
    //         $stok = $produk->stok;
    //         $kurangistok = $stok - $item->quantity;
    //         $updateStok = produk::where('id', $item->id_produk)->update(['stok' => $kurangistok]);
    //     }
    
    //     return redirect()->back()->with('success', 'Pembayaran berhasil.');
    // }

    public function nota($id)
{
    $order = Order::with(['user', 'orderDetails.produk'])->findOrFail($id);
    return view('pdf.nota', compact('order'));
}

}
//     public function pembayaran(Request $request, $id)
// {
//     // Clean the nominal_pembayaran to remove thousand separators
//     $nominalPembayaran = str_replace('.', '', $request->nominal_pembayaran);

//     // Validate the input
//     $validatedData = $request->validate([
//         'metode_pembayaran' => 'required',
//         'nominal_pembayaran' => 'required|numeric|min:0',
//     ]);

//     // Now we can safely use the cleaned value
//     $validatedData['nominal_pembayaran'] = (int)$nominalPembayaran;

//     $order = Order::findOrFail($id);

//     // Calculate 'kembalian'
//     $total = $order->total;
//     $kembalian = $validatedData['nominal_pembayaran'] - $total;

//     // Update the order
//     $order->update([
//         'metode_pembayaran' => $validatedData['metode_pembayaran'],
//         'nominal_pembayaran' => $validatedData['nominal_pembayaran'],
//         'kembalian' => $kembalian,
//         'waktu_pembayaran' => now(),
//         'status' => 'selesai',
//     ]);

//     return redirect()->back()->with('success', 'Pembayaran berhasil.');
// }
