@extends("navbar")

@section("title")
    <title>Dashboard</title>
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
        <p>120</p>
    </div>
    <div class="card">
        <h2>Total Pendapatan</h2>
        <p>Rp 10.000.000</p>
    </div>
    <div class="card">
        <h2>Produk Terjual</h2>
        <p>450</p>
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
        <tr>
            <td>001</td>
            <td>Kopi</td>
            <td>2</td>
            <td>Rp 20.000</td>
            <td>2025-03-12</td>
        </tr>
        <tr>
            <td>002</td>
            <td>Teh</td>
            <td>1</td>
            <td>Rp 10.000</td>
            <td>2025-03-12</td>
        </tr>
        <tr>
            <td>003</td>
            <td>Roti</td>
            <td>3</td>
            <td>Rp 30.000</td>
            <td>2025-03-12</td>
        </tr>
    </tbody>
</table>
@endsection
