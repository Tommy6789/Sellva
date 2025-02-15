<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = User::findOrFail(auth()->id()); // Get the logged-in user
        $profile = Profile::where('id_user', $user->id)->first(); // Get user's profile

        return view('dashboard.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request, string $id)
{
    // Find the user
    $user = User::findOrFail($id);

    // Validate input data
    $validatedData = $request->validate([
        'nik'            => 'nullable|string|max:16',
        'npwp'           => 'nullable|string|max:16',
        'gender'         => 'nullable|in:Male,Female',
        'tanggal_lahir'  => 'nullable|date',
        'alamat'         => 'nullable|string|max:255',
        'nomor_telepon'  => 'nullable|string|max:15',
        'foto'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
    ]);

    // Update user basic information
    $user->update([
        'alamat'        => $validatedData['alamat'] ?? $user->alamat,
        'nomor_telepon' => $validatedData['nomor_telepon'] ?? $user->nomor_telepon,
    ]);

    // Get or create profile
    $profile = Profile::firstOrCreate(['id_user' => $user->id]);

    // Handle file upload if a new file is provided
    if ($request->hasFile('foto')) {
        // Delete old image if exists
        if ($profile->foto && file_exists(storage_path('app/public/' . $profile->foto))) {
            unlink(storage_path('app/public/' . $profile->foto));
        }

        $imageName = time() . '.' . $request->foto->extension();
        $request->foto->storeAs('public/FotoProfile', $imageName);
        $validatedData['foto'] = 'FotoProfile/' . $imageName;
    }

    // Update profile information
    $profile->update([
        'nik'           => $validatedData['nik'] ?? $profile->nik,
        'npwp'          => $validatedData['npwp'] ?? $profile->npwp,
        'gender'        => $validatedData['gender'] ?? $profile->gender,
        'tanggal_lahir' => $validatedData['tanggal_lahir'] ?? $profile->tanggal_lahir,
        'foto'          => $validatedData['foto'] ?? $profile->foto,  // Changed this line
    ]);

    return redirect()->route('profile', ['id' => $user->id])->with('success', 'Profile updated successfully!');
}
}
