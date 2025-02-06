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
        if (Auth::check()) {
            $data = DB::table('produks')
                ->Leftjoin('keranjangs', 'produks.id', '=', 'keranjangs.id_produk')
                ->select('produks.*', 'keranjangs.quantity')
                ->get();
        } else {
            $data = produk::all();
        }
        return view('landingPage.shop', compact('data'));
    }

    public function kasir()
    {
        $data = order::all();
        return view('landingPage.kasir', compact('data'));
    }

    public function pembayaran(Request $request, $id)
{
    $validatedData = $request->validate([
        'metode_pembayaran' => 'required',
        'nominal_pembayaran' => 'required|numeric|min:0',
    ]);

    $validatedData['nominal_pembayaran'] = $validatedData['nominal_pembayaran'];

    $order = Order::findOrFail($id);

    // Calculate 'kembalian'
    $total = $order->total;
    $kembalian = $validatedData['nominal_pembayaran'] - $total;

    // Update the order
    $order->update([
        'metode_pembayaran' => $validatedData['metode_pembayaran'],
        'nominal_pembayaran' => $validatedData['nominal_pembayaran'],
        'kembalian' => $kembalian,
        'waktu_pembayaran' => now(),
        'status' => 'selesai',
    ]);

    return redirect()->back()->with('success', 'Pembayaran berhasil.');
}



}
