<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

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
            $cartItem = Keranjang::where('id_user', $userId)
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
}
