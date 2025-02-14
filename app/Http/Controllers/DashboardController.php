<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\order;
use App\Models\produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Produk::count();
        $totalOrders = order::count();
        $totalCartItems = keranjang::count();
        $recentOrders = Order::with('user')->orderBy('waktu_order', 'desc')->take(5)->get();
    
        return view('dashboard.index', compact('totalUsers', 'totalProducts', 'totalOrders', 'totalCartItems', 'recentOrders'));
    }    

    public function dataUsers()
    {
        $users = User::all();
        return view('dashboard.dataUsers', compact('users'));
    }

    public function updateRole(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return redirect()->route('dataUsers')->with('success', 'Role berhasil diperbarui.');
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
}
