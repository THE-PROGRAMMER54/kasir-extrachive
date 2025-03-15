@extends('navbar')

@section('title')
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
@endsection

@section('content')
<main class="container">
    <h1 class="title">Kasir</h1>

    <!-- Search Produk -->
    <div class="search">
        <input type="text" class="search-bar" placeholder="Cari Produk...">
        <i class="ph ph-magnifying-glass"></i>
    </div>

    <div class="wrapper">
        <!-- Produk -->
        <section class="products">
            <div class="product-card">
                <img src="storage/default-produk.png" alt="Produk">
                <h3>Produk A</h3>
                <p class="price">Rp 10.000</p>
                <input type="number" name="quantity" value="1" min="1">
                <button class="btn">Tambah</button>
            </div>
            <div class="product-card">
                <img src="storage/default-produk.png" alt="Produk">
                <h3>Produk B</h3>
                <p class="price">Rp 20.000</p>
                <input type="number" name="quantity" value="1" min="1">
                <button class="btn">Tambah</button>
            </div>
            <div class="product-card">
                <img src="storage/default-produk.png" alt="Produk">
                <h3>Produk B</h3>
                <p class="price">Rp 20.000</p>
                <input type="number" name="quantity" value="1" min="1">
                <button class="btn">Tambah</button>
            </div>
            <div class="product-card">
                <img src="storage/default-produk.png" alt="Produk">
                <h3>Produk B</h3>
                <p class="price">Rp 20.000</p>
                <input type="number" name="quantity" value="1" min="1">
                <button class="btn">Tambah</button>
            </div>
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
                        <tr>
                            <td>Produk A</td>
                            <td>Rp 10.000</td>
                            <td>2</td>
                            <td>Rp 20.000</td>
                            <td><button class="btn-hapus">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Harga -->
            <p class="total-harga">Total: <strong>Rp 20.000</strong></p>

            <!-- Form Pembayaran -->
            <form class="payment-form">
                <label for="bayar">Uang Dibayarkan:</label>
                <input type="number" id="bayar" name="bayar" placeholder="Masukkan jumlah uang" min="0">
                <p class="kembalian">Kembalian: <strong>Rp 0</strong></p>
                <button type="submit" class="btn-bayar">Bayar</button>
            </form>
        </section>
    </div>
</main>

@endsection
