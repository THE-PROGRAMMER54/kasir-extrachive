@extends("navbar")
@section("title")
    <title>Produk</title>
    <link rel="stylesheet" href="css/produk.css">
@endsection

@section("content")
<div class="container">
    <h1 class="page-title">Data Produk</h1>

    @if (auth()->user()->role === 'admin')
    <div class="action-buttons">
        <button class="btn tambah">+ Tambah Produk</button>
    </div>
    @endif

    <div class="table-container">
        <table class="produk-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    @if (auth()->user()->role === 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            @forelse ($data as $barang)
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>Rp {{ number_format($barang->harga,'0',',','.') }}</td>
                        <td>{{ number_format($barang->stok,'0',',','.') }}</td>
                        @if (auth()->user()->role === 'admin')
                            <td>
                                <div class="action-wrapper">
                                    <button class="btn edit">Edit</button>
                                    <button class="btn delete">Hapus</button>
                                </div>
                            </td>
                        @endif
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? 5 : 4 }}" class="text-center">Tidak ada data produk</td>
                    </tr>
                </tbody>
            @endforelse
        </table>
    </div>
</div>
@endsection
