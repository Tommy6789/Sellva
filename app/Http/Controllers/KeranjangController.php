<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
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


}
