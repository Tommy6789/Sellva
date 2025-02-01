<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;

class DataProdukController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$data = produk::all();
		return view('dashboardPetugas.dataProduk', compact('data'));
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
		// Validate incoming data
		$validatedData = $request->validate([
			'nama' => 'required|string|max:255',
			'harga' => 'required|integer|min:0',
			'stok' => 'required|integer|min:0',
			'tanggal_masuk' => 'required|date',
			'expire' => 'required|date',
			'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // File must be an image
		]);

		// Handle file upload
		if ($request->hasFile('gambar')) {
			$imageName = time() . '.' . $request->gambar->extension();

			// Save the image to the folder storage/app/public/GambarProduk
			$request->gambar->storeAs('public/GambarProduk', $imageName);

			// Save the file path in validated data
			$validatedData['gambar'] = 'GambarProduk/' . $imageName;
		}

		// Save product to the database
		Produk::create($validatedData);

		// Redirect back with a success message
		return redirect()->route('dataProduk.index')->with('success', 'Produk berhasil ditambahkan.');
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
    // Debug: Dump and die to check incoming data

    // Validate incoming data
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0',
        'tanggal_masuk' => 'required|date',
        'expire' => 'required|date',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File is optional for update
    ]);

    // Find the product by ID
    $produk = Produk::findOrFail($id);

    // Handle file upload if a new file is provided
    if ($request->hasFile('gambar')) {
        // Delete old image if exists
        if ($produk->gambar && file_exists(storage_path('app/public/' . $produk->gambar))) {
            unlink(storage_path('app/public/' . $produk->gambar));
        }

        $imageName = time() . '.' . $request->gambar->extension();
        $request->gambar->storeAs('public/GambarProduk', $imageName);
        $validatedData['gambar'] = 'GambarProduk/' . $imageName;
    }

    // Update the product data
    $produk->update($validatedData);

    // Redirect back with a success message
    return redirect()->route('dataProduk.index')->with('success', 'Produk berhasil diperbarui.');
}

	public function destroy(string $id)
	{
		// Find the product by ID
		$produk = Produk::findOrFail($id);

		// Delete the associated image file if it exists
		if ($produk->gambar && file_exists(storage_path('app/public/' . $produk->gambar))) {
			unlink(storage_path('app/public/' . $produk->gambar));
		}

		// Delete the product from the database
		$produk->delete();

		// Redirect back with a success message
		return redirect()->route('dataProduk.index')->with('success', 'Produk berhasil dihapus.');
	}
}
