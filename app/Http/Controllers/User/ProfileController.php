<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Tidak perlu transformasi URL di sini, biarkan view yang handle
        // ImageKit URL sudah disimpan lengkap di database
        
        return view('user.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function editPassword()
    {
        return view('user.profile.password.edit');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('user.profile.index')->with('success', 'Password changed successfully.');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar seperti AdminPengumumanController
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imagePath = $image->getPathname();
            $imageName = 'profile_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Upload ke ImageKit menggunakan metode yang sama dengan AdminPengumumanController
            $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                ->attach('file', fopen($imagePath, 'r'), $imageName)
                ->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'fileName' => $imageName,
                    'folder' => '/chibico/profile',
                ]);

            \Log::info('ImageKit Upload Response: ' . $response->body());

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['url'])) {
                    // Simpan URL lengkap dari ImageKit
                    $validated['profile_photo'] = $responseData['url'];
                    
                    // Hapus foto lama jika ada (opsional - tergantung kebutuhan storage)
                    if ($user->profile_photo && $user->profile_photo !== $responseData['url']) {
                        // Bisa ditambahkan fungsi delete dari ImageKit jika diperlukan
                        $this->deleteFromImageKit($user->profile_photo);
                    }
                } else {
                    return back()->withErrors([
                        'profile_photo' => 'Gagal mendapatkan URL gambar dari ImageKit'
                    ]);
                }
            } else {
                return back()->withErrors([
                    'profile_photo' => 'Gagal mengunggah foto ke ImageKit'
                ]);
            }
        }

        $user->update($validated);

        return redirect()->route('user.profile.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Menghapus gambar dari ImageKit (opsional)
     */
    private function deleteFromImageKit($photoUrl)
    {
        try {
            // Ekstrak file ID dari URL ImageKit
            $fileId = $this->extractFileIdFromUrl($photoUrl);
            
            if ($fileId) {
                $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                    ->delete('https://api.imagekit.io/v1/files/' . $fileId);

                \Log::info('ImageKit delete response: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Failed to delete image from ImageKit: ' . $e->getMessage());
        }
    }

    /**
     * Extract file ID dari URL ImageKit
     */
    private function extractFileIdFromUrl($url)
    {
        // ImageKit URL format: https://ik.imagekit.io/your_imagekit_id/path/filename.ext
        // File ID biasanya di response JSON saat upload, tapi jika tidak tersimpan,
        // kita bisa coba ekstrak dari URL atau gunakan ImageKit list files API
        
        // Untuk sekarang, return null jika tidak bisa ekstrak
        // Implementasi tergantung bagaimana Anda ingin handle ini
        return null;
    }

    /**
     * Method untuk menampilkan gambar dengan transformasi
     */
    public function getProfileImage($userId, Request $request)
    {
        $user = User::findOrFail($userId);
        
        if (!$user->profile_photo) {
            return response()->json(['error' => 'No profile photo found'], 404);
        }

        // Tambahkan transformasi ImageKit
        $width = $request->get('w', 150);
        $height = $request->get('h', 150);
        $quality = $request->get('q', 80);
        
        // Tambahkan parameter transformasi ImageKit
        $transformedUrl = $user->profile_photo . '?tr=w-' . $width . ',h-' . $height . ',q-' . $quality . ',c-maintain_ratio';
        
        return response()->json([
            'url' => $transformedUrl,
            'original_url' => $user->profile_photo
        ]);
    }

    /**
     * Method untuk redirect ke gambar ImageKit
     */
    public function showImage($userId, Request $request)
    {
        $user = User::findOrFail($userId);
        
        if (!$user->profile_photo) {
            // Return default image
            return response()->file(public_path('images/default-avatar.png'));
        }

        // Redirect ke URL ImageKit
        return redirect($user->profile_photo);
    }
}