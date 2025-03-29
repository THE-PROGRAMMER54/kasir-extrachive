<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                if(Auth::user()->role == 'admin'){
                    return redirect()->route('dashboard')->with('success-login', 'Login berhasil');
                }else{
                    return redirect()->route('kasir')->with('success-login', 'Login berhasil');
                }
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
        return redirect()->route('login')->with('success', 'Logout berhasil');
    }

    public function pengaturan(){
        return view('pengaturan');
    }

    public function updatephoto(Request $request,string $id){
        try{
            $data = User::findOrFail($id);
            $request->validate([
                'gambar' => 'image|mimes:jpeg,png,jpg|max:5048'
            ]);
            if($request->hasFile('gambar')){
                $oldgambar = $data->gambar;

                if($oldgambar != "profile.jpg" && file_exists(public_path('storage/'.$oldgambar))){
                    unlink(public_path('storage/'.$oldgambar));
                }

                $nama_gambar = time()."_".$request->gambar->getClientOriginalName();
                $request->gambar->move(public_path('storage'), $nama_gambar);
                $data->gambar = $nama_gambar;
                $data->save();
            }
            return redirect()->route('pengaturan')->with('success', 'Foto berhasil diubah');
        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal mengganti foto".$e->getMessage()]);
        }
    }

    public function deletephoto(string $id){
        try{
            $data = User::findOrFail($id);
            $oldgambar = $data->gambar;

            if($oldgambar!= "profile.jpg" && file_exists(public_path('storage/'.$oldgambar))){
                unlink(public_path('storage/'.$oldgambar));
            }
            $data->gambar = "profile.jpg";
            $data->save();
            return redirect()->route('pengaturan')->with('success', 'Foto berhasil dihapus');
        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal menghapus foto".$e->getMessage()]);
        }
    }

    public function edituser(string $id,Request $request){
        try{
            $data = User::findOrFail($id);
            $request->validate([
                'name' => 'max:255',
                'email' => 'max:255'
            ]);

            if($request->email != ""){
                if(!Str::endsWith($request->email,['@gmail.com','@yahoo.com'])){
                    $email = $request->email.".com";
                    $data->email = $email;
                }
            }

            if($request->name != ""){
                $data->name = $request->name;
            }

            $data->save();
            return redirect()->route('pengaturan')->with('success', 'Data berhasil diubah');

        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal mengedit data user".$e->getMessage()]);
        }
    }

    public function editpass(string $id,Request $request){
        try{
            $data = User::findOrFail($id);
            if(hash::check($request->password,$data->password)){
                $request->validate([
                    'new-pass' => 'required|min:8',
                    'confirm-pass' => 'required|same:new-pass'
                ]);

                $data->password =  bcrypt($request->password);
                $data->save();
                return redirect()->route('pengaturan')->with('success', 'Password berhasil diubah');
            }else{
                return redirect()->back()->with('error', 'Password lama salah');
            }
        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal mengedit password user".$e->getMessage()]);
        }
    }

    public function deleteakun(string $id){
        try{
            $data = User::findOrFail($id);
            $oldgambar = $data->gambar;
            if($oldgambar != "profile.jpg" && file_exists(public_path('storage/'.$oldgambar))){
                unlink(public_path('storage/'.$oldgambar));
            }
            $data->delete();
            Auth::logout();
            return redirect()->route('login')->with('success', 'Akun berhasil dihapus, silahkan daftar kembali');
        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal menghapus akun user".$e->getMessage()]);
        }
    }

    public function users(){
        $data = User::all();
        return view('users',compact('data'));
    }

    public function editdatauser(Request $request,string $id){
        try{
            $user = User::findOrFail($id);
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'role' => 'required',
                'gambar' => 'image|mimes:jpeg,png,jpg|max:5048|nullable'
            ]);

            $user->name = $request->name;
            if(!Str::endsWith($request->email,["@gmail.com","@yahoo.com"])){
                $email = $request->email.".com";
                $user->email = $email;
            }
            $user->role = $request->role;
            if($request->hasFile('gambar')){
                $oldgambar = $user->gambar;
                if($oldgambar!= "profile.jpg" && file_exists(public_path('storage/'.$oldgambar))){
                    unlink(public_path('storage/'.$oldgambar));
                }
                $nama_gambar = time()."_".$request->gambar->getClientOriginalName();
                $request->gambar->move(public_path('storage'), $nama_gambar);
                $user->gambar = $nama_gambar;
            }
            $user->save();
            return redirect()->route('users')->with('success', 'Data berhasil diubah');
        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal mengedit data user".$e->getMessage()]);
        }
    }

    public function deleteuserakun(string $id){
        try{
            $data = User::findOrFail($id);
            $oldgambar = $data->gambar;
            if($oldgambar != "profile.jpg" && file_exists(public_path('storage/'.$oldgambar))){
                unlink(public_path('storage/'.$oldgambar));
            }
            $data->delete();
            return redirect()->back()->with('success', 'Akun user berhasil dihapus');
        }catch(Exception $e){
            return redirect()->back()->with(["error" =>"gagal menghapus akun user".$e->getMessage()]);
        }
    }
}
