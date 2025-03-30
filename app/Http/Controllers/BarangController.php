<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Exception;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function produk()
    {
        $data = barang::all();
        return view('produk', ['data' => $data]);
    }

    public function tporduk(Request $request){
        try{
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'stok' => 'required|integer',
                'harga' => 'required|integer',
                'gambar' => 'image|mimes:jpeg,png,jpg|max:5048|required',
                'diskon' => 'integer'
            ]);
            if($request->diskon < 0 || $request->diskon >100){
                return redirect()->back()->with(['error' => 'Diskon harus antara 0 dan 100!']);
            }

            $produk = new barang();
            $produk->nama_barang = $request->nama_barang;
            $produk->stok = $request->stok;
            $produk->harga = $request->harga;
            $produk->diskon = $request->diskon;
            if ($request->diskon > 0) {
                $produk->hasil_diskon = $request->harga - ($request->harga * $request->diskon / 100);
            } else {
                $produk->hasil_diskon = $request->harga;
            }

            if($request->hasFile('gambar')){
                $nama_gambar = time()."_".$request->gambar->getClientOriginalName();
                $request->gambar->move(public_path('storage'), $nama_gambar);
                $produk->gambar = $nama_gambar;
            }
            $produk->save();

            return redirect('/produk')->with(['success' => 'Product berhasil ditambahkan!']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Gagal menambah Product, silahkan coba lagi!!, '.$e->getMessage()]);
        }
    }
    public function eporduk(Request $request,string $kode_barang){
        try{
            $request->validate([
                'nama_barang' => 'string|max:255',
                'harga' => 'integer',
                'gambar' => 'image|mimes:jpeg,png,jpg|max:5048',
                'diskon' => 'integer'
            ]);

            $produk = barang::findOrFail($kode_barang);
            $produk->nama_barang = $request->nama_barang;
            $produk->harga = $request->harga;
            $produk->diskon = $request->diskon;
            if ($request->diskon > 0) {
                $produk->hasil_diskon = $request->harga - ($request->harga * $request->diskon / 100);
            } else {
                $produk->hasil_diskon = $request->harga;
            }


            if($request->hasFile('gambar')){
                $path = public_path('storage/'.$produk->gambar);

                if(file_exists($path) && $produk->gambar != "default-produk.png"){
                    unlink($path);
                }

                $nama_gambar = time()."_".$request->gambar->getClientOriginalName();
                $request->gambar->move(public_path('storage'), $nama_gambar);
                $produk->gambar = $nama_gambar;
            }

            $produk->update();

            return redirect('/produk')->with(['success' => 'Data berhasil diedit!']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Gagal menambah data, silahkan coba lagi!!, '.$e->getMessage()]);
        }
    }

    public function tstok(Request $request,string $kode_barang){
        try{
            $request->validate(['stok'=> 'integer']);
            $stok = barang::findOrFail($kode_barang);
            $stok->stok = $stok->stok += $request->stok;
            $stok->update();

            return redirect()->back()->with(['success' => 'Stok berhasil ditambah!']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Gagal menambahkan stok, silahkan coba lagi!!']);
        }
    }

    public function deleteproduk(string $kode_barang){
        try{
            $produk = barang::findOrFail($kode_barang);
            $path = public_path('storage/'.$produk->gambar);
            if(file_exists($path) && $produk->gambar != "default-produk.png"){
                unlink($path);
            }
            $produk->delete();

            return redirect('/produk')->with(['success' => 'Data berhasil dihapus!']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Gagal menghapus data, silahkan coba lagi!!']);
        }
    }
}
