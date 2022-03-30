<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function postLogin()
    {
        $credentials = Request::validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            Request::session()->regenerate();

            return redirect('/recipes')->with('success', 'You have logged in.');
        }
        return back()->withErrors('something went wrong');
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function postRegister()
    {

        $existingUser = User::where('email', Request::input('email'))->first();

        if ($existingUser != null) {
            return redirect('/register')->with('error', "an account with email $existingUser->email already exists.");
        } else {
            if (Request::file('file_path')) {
                $request = Request::validate([
                    'name' => 'required|string|min:2|max:64',
                    'email' => 'required|email',
                    'password' => 'required',
                    'file_path' => 'required|mimes:jpg,png,jpeg'
                ]);

                $filenameWithExt = Request::file('file_path')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = Request::file('file_path')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Upload Image

                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => bcrypt($request['password']),
                    'file_path' => Request::file('file_path')->storeAs('public/avatars', $fileNameToStore)
                ]);
            } else {
                $request = Request::validate([
                    'name' => 'required|string|min:2|max:64',
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => bcrypt($request['password']),
                    'file_path' => Str::random(10)
                ]);
            }
            $data = ['message' => 'and don\'t forget to say hi to tiggy! Meoww'];

            Mail::to($user->email)->send(new TestEmail($data));
            auth()->attempt(['email' => $request['email'], 'password' => $request['password']]);
            return redirect('/recipes')->with('success', 'you have registered.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have logged out');
    }
}
