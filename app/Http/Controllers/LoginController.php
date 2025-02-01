<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login.login');
    }

    public function register()
    {
        return view('login.register');
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
            // Validate input data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8|confirmed',
                'nomor_telepon' => 'required|numeric|digits_between:8,15',
                'alamat' => 'required|string|max:255',
                'terms' => 'accepted',
                'role' => 'nullable'
            ], [
                'terms.accepted' => 'Anda harus menyetujui persyaratan dan ketentuan.',
                'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
            ]);

            // Create a new user
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->nomor_telepon = $validatedData['nomor_telepon'];
            $user->alamat = $validatedData['alamat'];
            $user->save();

            // Redirect to the login page with a success message
            return redirect()->route('login.index')->with('success', 'Akun Anda berhasil dibuat!');
        }

    public function loginCheck(Request $request)
    {
        // Validate the request inputs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation
            $request->session()->regenerate();

            // Redirect to dashboardPetugas with success message
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function logout()
    {
        Auth::logout(); //Log out pengguna
        return redirect()->route('home')->with('success', 'Logout Berhasil!'); //Redirect ke halaman utama
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
