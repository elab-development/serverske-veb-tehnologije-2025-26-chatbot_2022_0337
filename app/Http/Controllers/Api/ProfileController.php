<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $validated['image']->store('profile-images', 'public');

        $user->update([
            'profile_image' => $path,
        ]);

        return response()->json([
            'message' => 'Profilna slika je uspešno sačuvana.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'profile_image' => $user->profile_image,
                'profile_image_url' => asset('storage/'.$user->profile_image),
            ],
        ]);
    }

    public function deleteImage(Request $request)
    {
        $user = $request->user();

        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->update([
            'profile_image' => null,
        ]);

        return response()->json([
            'message' => 'Profilna slika je uspešno obrisana.',
        ]);
    }
}
