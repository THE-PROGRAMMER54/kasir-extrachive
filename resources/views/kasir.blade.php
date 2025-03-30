@extends('navbar')

@section('title')
    <title>Kasir</title>
    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"/>
@endsection

@section('content')
<main class="container">
    <h1 class="title">Kasir</h1>

    <!-- Search Produk -->
    <div class="search">
        <form action="{{ route('searchkasir') }}" method="post">
            @csrf
            <input type="text" name="keyword" class="search-bar" placeholder="Cari Produk...">
            <button type="submit">
                <i class="ph ph-magnifying-glass"></i>
            </button>
        </form>
    </div>

    {{-- Produk --}}
    <div class="wrapper">
        <section class="products">
            @forelse ($data as $product)
                <div class="product-card">
                    @if (($product['sisa'] - (session('cart')[$product['kode_barang']]['jumlah'] ?? 0)) > 0)
                        <form action="{{ route('tkeranjang') }}" method="post">
                            @csrf
                            <input type="hidden" name="kode_barang" value="{{ $product['kode_barang'] }}">
                            <input type="hidden" name="nama_barang" value="{{ $product['nama_barang'] }}">
                            <input type="hidden" name="harga" value="{{ $product['harga'] }}">

                            @if (!empty($product['gambar']) && file_exists(public_path('storage/'.$product['gambar'])))
                                <img src="{{ asset('storage/'.$product['gambar']) }}" alt="Produk">
                            @else
                                <img src="{{ asset('storage/default-produk.png') }}" alt="Produk">
                            @endif

                            <h3>{{ $product['nama_barang']}}</h3>
                            <p class="price">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                            <input type="number" name="jumlah" value="1" min="1">
                            <button class="btn">Tambah ke keranjang</button>
                        </form>
                    @else
                        @if (!empty($product['gambar']) && file_exists(public_path('storage/'.$product['gambar'])))
                            <img src="{{ asset('storage/'.$product['gambar']) }}" alt="Produk">
                        @else
                            <img src="{{ asset('storage/default-produk.png') }}" alt="Produk">
                        @endif
                        <h3>{{ $product['nama_barang']}}</h3>
                        <p class="price">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                        <button class="btn-habis">Barang Habis</button>
                    @endif
                </div>
            @empty
                <div class="product-card" style="width: 100%;">
                    <p> Tidak Ada Produk </p>
                </div>
            @endforelse
        </section>

        <!-- Keranjang -->
        <section class="cart">
            <h2>Keranjang Belanja</h2>
            <div class="cart-content">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (session()->has('cart') && count(session('cart')) > 0)
                            @foreach (session('cart') as $item)
                                <tr>
                                    <td>{{ $item['nama_barang'] }}</td>
                                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                    <td>Rp {{ $item['harga'] * number_format($item['jumlah'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('dkeranjang', $item['kode_barang']) }}" method="post">
                                            @csrf
                                            <button class="btn-hapus">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Silahkan Pilih Produk</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Total Harga -->
            <p class="total-harga">Total: <strong>Rp {{ number_format(session('total'), 0, ',', '.') }}</strong></p>

            <!-- Form Pembayaran -->
            <form class="payment-form" method="post" action="{{ route('bayar') }}">
                @csrf
                <label for="bayar">Uang Dibayarkan:</label>
                <input type="number" id="bayar" name="bayar" placeholder="Masukkan jumlah uang" min="0">
                <p class="kembalian">Kembalian: <strong>
                    Rp @if (session('kembalian'))
                        <strong>{{ number_format(session('kembalian'),'0',',','.') }}</strong>
                    @else
                    0
                    @endif
                </strong></p>
                <button type="submit" class="btn-bayar">Bayar</button>
            </form>
        </section>
    </div>
    @if (session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif
</main>
@endsection

