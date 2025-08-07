<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Load department relationship
        if ($user->department_id) {
            $user->load('department');
        }
        
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $departments = Department::all();
        
        // Load department relationship
        if ($user->department_id) {
            $user->load('department');
        }
        
        return view('profile.edit', compact('user', 'departments'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'department_id' => 'nullable|exists:departments,id',
            'student_id' => 'nullable|string|max:20',
            'admission_semester' => 'nullable|in:Spring,Summer,Fall',
            'admission_year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($request->only([
            'name',
            'email',
            'phone',
            'address',
            'department_id',
            'student_id',
            'admission_semester',
            'admission_year'
        ]));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePicture(Request $request)
    {
        $user = Auth::user();


        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:4096'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');

        $user->update(['profile_picture' => $path]);

        return redirect()->route('profile.edit')->with('success', 'Profile picture updated successfully!');
    }
}
