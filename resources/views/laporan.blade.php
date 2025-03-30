@extends("navbar")

@section("title")
    <title>Laporan</title>
    <link rel="stylesheet" href="css/laporan.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"/>
@endsection

@section("content")
<div class="container">
    <h2>Laporan Transaksi</h2>

    <!-- Form Filter -->
    <form method="post" action="{{ route('tanggalLaporan') }}" class="filter-form">
        @csrf
        <label for="start_date">Dari Tanggal:</label>
        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">

        <label for="end_date">Sampai Tanggal:</label>
        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">

        <button type="submit">Filter</button>
    </form>


        <!-- Laporan Stok -->
        <div class="table-container">
            <h3>Laporan Stok</h3>
            <div class="laporan-table-container">
                <table class="laporan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Stok Awal</th>
                            <th>Stok Terjual</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sisa as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang['nama_barang'] }}</td>
                            <td>{{ $barang['awal'] }}</td>
                            <td>{{ $barang['terjual'] }}</td>
                            <td>{{ $barang['sisa'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5"> Tidak Ada Barang</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    <!-- Laporan Penjualan -->
    <div class="table-container">
        <h3>Laporan Penjualan</h3>
        <div class="laporan-table-container">
            <table class="laporan-table">
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
                    @php $no = 1 @endphp
                    @forelse ($penjualan as $terjual)
                    @foreach ($terjual->detail_penjualan as $dp)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $dp->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                            <td>{{ $dp->jumlah }}</td>
                            <td>Rp {{ number_format($dp->total, 0, ',', '.') }}</td>
                            <td>{{ $dp->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                        @empty
                            <tr>
                                <td colspan="5">Tidak Ada Transaksi</td>
                            </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
