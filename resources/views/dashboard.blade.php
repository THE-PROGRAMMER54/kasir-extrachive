@extends("navbar")

@section("title")
    <title>Data Users</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
@endsection

@section("content")
<h1 class="dashboard-title">Dashboard</h1>
<div class="grid-container">
    <div class="card">
        <h2>Total Transaksi</h2>
        <p>{{ $penjualan->count('id_penjualan') }}</p>
    </div>
    <div class="card">
        <h2>Total Pendapatan</h2>
        <p>Rp {{ number_format($data[0]['pendapatan'],0,',','.') }}</p>
    </div>
    <div class="card">
        <h2>Produk Terjual</h2>
        <p>{{ $data[0]['terjual'] }}</p>
    </div>
</div>

        <!-- Transaksi Terbaru -->
<h2 class="section-title">Transaksi Terbaru</h2>
<table class="transaction-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($detail_transaksi as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->barang->nama_barang }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>Rp {{ number_format($item->total,0,',','.') }}</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center;">Tidak Ada Transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
