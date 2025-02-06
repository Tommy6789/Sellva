<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\order;
use App\Models\orderDetail;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function updateKeranjang(Request $request)
    {
        $keranjang = keranjang::updateOrCreate(
            ['id_produk' => $request->id_produk, 'id_user' => Auth::user()->id],
            ['quantity' => $request->quantity]
        );

        return response()->json($keranjang);
    }

    public function deleteKeranjang(Request $request)
    {
        try {
            $userId = auth()->id();
            $productId = $request->id_produk;

            // Find the cart item
            $cartItem = keranjang::where('id_user', $userId)
                ->where('id_produk', $productId)
                ->first();

            if (!$cartItem) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            // Delete the item
            $cartItem->delete();

            return response()->json(['message' => 'Item removed from cart']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting item', 'error' => $e->getMessage()], 500);
        }
    }

    public function getCartCount()
    {
        $userId = auth()->id();

        // If the user is not logged in, return 0
        if (!$userId) {
            return response()->json(['count' => 0]);
        }

        // Count distinct products in the cart
        $totalItems = Keranjang::where('id_user', $userId)
            ->distinct('id_produk')
            ->count('id_produk'); // Count distinct product IDs

        return response()->json(['count' => $totalItems]);
    }

    public function keranjangPage()
    {
        $data = keranjang::all();
        return view('landingPage.keranjang', compact('data'));
    }

    public function keranjangCheckout()
{
    $user = auth()->user();

    // Get all cart items of the logged-in user
    $cartItems = Keranjang::where('id_user', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
    }

    // Calculate total price
    $totalPrice = $cartItems->sum(function ($item) {
        $price = (int) $item->produk->harga;  // Assume harga is a plain numeric value
        return $item->quantity * $price;
    });

    try {
        // Create a new order
        $order = Order::create([
            'id_user'     => $user->id,
            'total'       => $totalPrice,
            'status'      => 'proses',
            'waktu_order' => now(),
        ]);

        // Create order details for each cart item
        $cartItems->each(function ($item) use ($order, $user) {
            $price = (int) $item->produk->harga;  // Assume harga is a plain numeric value
            $subtotal = $item->quantity * $price;

            OrderDetail::create([
                'id_user'   => $user->id,
                'id_order'  => $order->id,
                'id_produk' => $item->id_produk,
                'quantity'  => $item->quantity,
                'harga'     => $price,
                'subtotal'  => $subtotal,
            ]);
        });

        // Clear the cart after successful checkout
        Keranjang::where('id_user', $user->id)->delete();

        return redirect()->route('home')->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan checkout. Silakan coba lagi.');
    }
}

}
