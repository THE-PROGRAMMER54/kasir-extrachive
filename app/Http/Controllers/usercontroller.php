<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class usercontroller extends Controller
{
    // login user
    public function login(){
        return view('login');
    }

    public function proseslogin(Request $request){
        try{
            $request->validate([
                'email' => 'required|max:255|string',
                'password' => 'required|min:8',
            ]);

            if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
                $request->session()->regenerate();
                return redirect()->route('dashboard')->with('success-login', 'Login berhasil');
            }else{
                return redirect()->back()->with('error-login', 'Username atau password salah');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error-login', 'Username atau password salah ,' . $e->getMessage());
        }
    }

    // register user
    public function register(){
        return view('regist');
    }

    public function prosesregist(Request $request){
        try{
            $request->validate([
                'name' => 'required|max:255|string',
                'email' => 'required|max:255|string',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'gambar' => 'image|mimes:jpeg,png,jpg|max:2048|nullable'
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;

            if($request->hasFile('gambar')){
                $nama_gambar = time()."_".$request->gambar->getClientOriginalName();
                $request->gambar->move(public_path('storage'), $nama_gambar);
                $user->gambar = $nama_gambar;
            }

            $user->password =  bcrypt($request->password);
            $user->save();
            return redirect()->route('login')->with('success-regist', 'Registrasi berhasil, silahkan login');
        }catch(Exception $e){
            return redirect()->back()->with('error-regist', 'gagal registrasi, silahkan coba lagi!! ,'.$e->getMessage());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success-logout', 'Logout berhasil');
    }
}
