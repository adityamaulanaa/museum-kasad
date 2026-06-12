<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $admin = Admin::where('username', $request->username)
                      ->where('password', $request->password)
                      ->first();

        if ($admin) {
            session([
                'admin_login' => true,
                'id_admin'    => $admin->id_admin, 
                'username'    => $admin->username
            ]);

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'login' => 'Username atau Password salah'
        ]);
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}