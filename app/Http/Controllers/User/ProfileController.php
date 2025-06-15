<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

    if ($request->hasFile('profile_photo')) {
        $filename = $request->file('profile_photo')->store('profile_photo', 'public');
        $validated['profile_photo'] = $filename;
    }

    $user->update($validated);
    

    return redirect()->route('user.profile.index')->with('success', 'Profile updated.');
}

    
}
