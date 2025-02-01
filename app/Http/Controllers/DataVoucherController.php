<?php

namespace App\Http\Controllers;

use App\Models\voucher;
use Illuminate\Http\Request;

class DataVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = voucher::all();
        return view('dashboardPetugas.dataVoucher', compact('data'));
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
    // dd($request->all());
    // Validate incoming request data
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'jumlah_diskon' => ['required', 'regex:/^\d+%?$/'], // Allow numbers with optional %
        'syarat' => 'required|string',
        'limit' => 'required|integer|min:0',
        'expire' => 'required|date',
    ]);

    // Store the voucher in the database
    Voucher::create($validatedData);

    // Redirect with a success message
    return redirect()->route('dataVoucher.index')->with('success', 'Voucher berhasil ditambahkan.');
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
        $data = voucher::all();
        return view('dashboardPetugas.dataVoucher');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_diskon' => 'required|numeric|min:0',
            'syarat' => 'required|string',
            'limit' => 'required|integer|min:0',
            'expire' => 'required|date',
        ]);

        // Find the voucher by ID
        $voucher = Voucher::findOrFail($id);

        // Update the voucher data
        $voucher->update($validatedData);

        // Redirect with a success message
        return redirect()->route('dataVoucher.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the voucher by ID
        $voucher = voucher::findOrFail($id);

        // Delete the voucher
        $voucher->delete();

        // Redirect with a success message
        return redirect()->route('dataVoucher.index')->with('success', 'Voucher berhasil dihapus.');
    }
}
