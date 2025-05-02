<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller 
{
    public function showDoctors() {
        $doctors = User::where('user_type', 'doctor')->get();
        return view('welcome', compact('doctors'));
    }

    public function rules($data) {
        $messages = [
            'email.required' => 'Please enter your email address',
            'email.exists' => 'This email does not exist in our records',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters long'
        ];
        return Validator::make($data, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ], $messages);
    }

    public function DocLogin(Request $request) {
        $valid = $this->rules($request->all());
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $email = $request->get('email');
        $password = $request->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password, 'user_type' => 'doctor'])) {
            return redirect()->intended('/doctor/dashboard');
        } else {
            return redirect()->back()->withErrors(['email' => 'The password do not match our records.'])->withInput();
        }
    }

    public function savedoc(Request $request) {
        $messages = [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be containing characters with spaces',
            'name.max' => 'Name cannot exceed 255 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email address is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters long',
            'password.confirmed' => 'Password in confirmation does not match',
            'spl.required' => 'Specialization is required',
            'spl.string' => 'Specialization must be containing characters with spaces',
            'spl.max' => 'Specialization cannot exceed 255 characters',
            'image.required' => 'Profile image is required',
            'image.mimes' => 'Profile image must be a file of type: jpeg, png, jpg, gif, svg',
            'image.max' => 'Profile image size cannot exceed 2MB'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'spl' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();  
            try {
                $request->image->move(public_path('images'), $imageName);
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return redirect()->back()->withErrors(['image' => 'Image upload failed.'])->withInput();
            }
        } else {
            Log::error('Image upload failed or image not present.');
            return redirect()->back()->withErrors(['image' => 'Image upload failed.'])->withInput();
        }

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'user_type' => 'doctor',
            'spl' => $request->get('spl'),
            'image' => $imageName
        ]);

        if ($user->save()) {
            return redirect()->intended('/doctor/dashboard');
        } else {
            Log::error('Failed to save user to the database.');
            return redirect()->back()->withErrors(['general' => 'Failed to save user information. Please try again.'])->withInput();
        }
    }
}
