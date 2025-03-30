<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\detail_penjualan;
use App\Models\penjualan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;

class PenjualanController extends Controller
{
    public function dashboard(){
        try{
            $penjualan = penjualan::all();
            $barang = barang::all();
            $detail_transaksi = detail_penjualan::whereDate('created_at',Carbon::today())->with('barang')->latest()->get()->take(10);
            $data = [];
            $total = 0;
            foreach ($penjualan as $item){
                $totalPendapatan = detail_penjualan::where('id_penjualan', $item->id_penjualan)->sum('total');
                $total = $total += $totalPendapatan;
            }

            $terjual = 0;
            foreach ($barang as $item){
                $dijual = detail_penjualan::where('kode_barang',$item->kode_barang)->sum('jumlah');
                $terjual = $terjual += $dijual;
            }

            $data[] = [
                'pendapatan' => $total,
                'terjual' => $terjual
            ];
            return view('dashboard',compact(['penjualan','data','detail_transaksi']));
        }catch(Exception $e){
            dd($e);
        }
    }

    public function kasir()
    {
        $barang = barang::all();
        $data = [];
        foreach ($barang as $item){

            $data[] = [
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'harga' => $item->harga,
                'gambar' => $item->gambar,
                'sisa' => $item->stok
            ];
        }
        return view('kasir',compact('data'));
    }


    public function tkeranjang(Request $request){
        try{
            $produk = barang::where('kode_barang', $request->kode_barang)->first();
            if(!$produk){
                return redirect()->back()->with('error', 'Barang yang dipilih tidak ditemukan');
            }

            $sisa = $produk->stok;
            if($sisa < $request->jumlah){
                return redirect()->back()->with('error', 'Stok barang yang dipilih hanya tersisa '. $sisa);
            }

            $cart = session()->get('cart',[]);

            if(isset($cart[$request->kode_barang])){
                $sisa_stok = $sisa - $cart[$request->kode_barang]['jumlah'];
                if($sisa_stok == 0){
                    return redirect()->back()->with('error', 'Stok barang yang dipilih sudah habis');
                }elseif($sisa_stok < $request->jumlah){
                    return redirect()->back()->with('error', 'Stok barang yang dipilih hanya tersisa '. $sisa_stok);
                }
                $cart[$request->kode_barang]['jumlah'] += $request->jumlah;
            }else{
                $cart[$request->kode_barang] = [
                    'nama_barang' => $produk->nama_barang,
                    'kode_barang' => $request->kode_barang,
                    'gambar' => $produk->gambar,
                    'harga' => $produk->harga,
                    'jumlah' => $request->jumlah
                ];
            }

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['harga'] * $item['jumlah'];
            }
            session()->put('cart', $cart);
            session()->put('total', $total);

            return redirect()->back();
        }catch(Exception $e){
            return redirect()->back()->with('error-keranjang', 'Gagal menambahkan ke keranjang, '. $e->getMessage());
        }
    }


    public function dkeranjang(Request $request, string $kode_barang){
        try{
            $cart = session()->get('cart',[]);

            if(isset($cart[$kode_barang])){
                unset($cart[$kode_barang]);
                session()->put('cart', $cart);
            }
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['harga'] * $item['jumlah'];
            }
            session()->put(['cart' => $cart, 'total' => $total]);
            return redirect()->back();
        }catch(Exception $e){
            return redirect()->back()->with('error-keranjang', 'Gagal menghapus item, '. $e->getMessage());
        }
    }

    public function bayar(Request $request){
        try{
            $request->validate([
                'bayar' => 'required|numeric|min:3',
            ]);

            $cart = session('cart', []);
            if (empty($cart)) {
                return redirect()->back()->with('error', 'Keranjang belanja kosong.');
            }

            $total = array_sum(array_map(fn($item) => $item['jumlah'] * $item['harga'],$cart));
            if($request->bayar < $total){
                return redirect()->back()->with('error', 'Uang anda kurang, silahkan bayar sesuai total harga.');
            }

            $jumlah_barang = array_sum(array_map(fn($item)=> $item['jumlah'],$cart));

            $penjualan = new penjualan();
            $penjualan->id_penjualan = Str::uuid()->toString();
            $penjualan->jumlah = $jumlah_barang;
            $penjualan->total = $total;
            $penjualan->total_bayar = $request->bayar;
            $penjualan->kembalian = $request->bayar - $total;
            $penjualan->save();

            foreach($cart as $detail){
                $detail_penjualan = new detail_penjualan();
                $detail_penjualan->id_penjualan = $penjualan->id_penjualan;
                $detail_penjualan->kode_barang = $detail['kode_barang'];
                $detail_penjualan->jumlah = $detail['jumlah'];
                $detail_penjualan->total = $detail['jumlah'] * $detail['harga'];
                $detail_penjualan->save();

                $stok = barang::where('kode_barang', $detail['kode_barang'])->first();
                $terjual = $stok->stok - $detail['jumlah'];
                $stok->stok = $terjual;
                $stok->save();
            }
            $kembalian =$request->bayar - $total;
            session()->forget('cart');
            $total = 0;
            session()->put(['kembalian' => $kembalian, 'total' => $total]);
            return redirect()->back();
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Gagal melakukan pembayaran, '. $e->getMessage());
        }
    }

    public function searchkasir(Request $request){
        try{
            $request->validate([
                'keyword' => 'required|string'
            ]);
            $data = barang::where('nama_barang', 'like', '%'. $request->keyword. '%')->get();
            return view('kasir', compact('data'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Gagal melakukan pencarian, '. $e->getMessage());
        }
    }

    public function laporan(){
        $penjualan = penjualan::with('detail_penjualan.barang')->latest()->get();

        $grouped = $penjualan->flatMap->detail_penjualan->groupBy('kode_barang')->map(function ($items) {
            return [
                'nama_barang' => $items->first()->barang->nama_barang ?? 'Barang tidak ditemukan',
                'jumlah' => $items->sum('jumlah'),
                'total' => $items->sum('total'),
            ];
        });
        $barang = barang::all();

        $sisa = $barang->map(function ($barang) use ($grouped){
            $jumlah = $grouped[$barang->kode_barang]['jumlah'] ?? 0;
            return [
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'terjual' => $jumlah,
                'sisa' => $barang->stok,
                'awal' => $barang->stok += $jumlah,
            ];
        });

        return view('laporan', compact(['penjualan','grouped','sisa']));
    }


    public function tanggalLaporan(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $penjualan = Penjualan::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->with('detail_penjualan.barang')
            ->latest()
            ->get();

        $grouped = $penjualan->flatMap->detail_penjualan->groupBy('kode_barang')->map(function ($items) {
            return [
                'nama_barang' => $items->first()->barang->nama_barang ?? 'Barang tidak ditemukan',
                'jumlah' => $items->sum('jumlah'),
                'total' => $items->sum('total'),
            ];
        });

        return view('laporan', compact('penjualan', 'grouped'));
    }
}
