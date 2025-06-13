<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // atau auth()->user()
        return view('user.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('profile_picture')) {
        $filename = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validated['profile_picture'] = $filename;
    }

    $user->update($validated);

    return redirect()->route('user.profile.index')->with('success', 'Profile updated.');
}

    
}
