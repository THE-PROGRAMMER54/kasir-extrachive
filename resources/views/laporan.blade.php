@extends("navbar")

@section("title")
    <title>Laporan</title>
    <link rel="stylesheet" href="css/laporan.css">
@endsection

@section("content")
<div class="container">
    <h2>Laporan Transaksi</h2>

    <!-- Form Filter -->
    <form class="filter-form">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal">
        <button type="submit">Filter</button>
    </form>

    <!-- Tabel 1: Laporan Penjualan -->
    <div class="table-container">
        <h3>Laporan Penjualan</h3>
        <div class="laporan-table-container">
            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#001</td>
                        <td>12-03-2025</td>
                        <td>Kopi</td>
                        <td>10</td>
                        <td>Rp 200.000</td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>13-03-2025</td>
                        <td>Teh</td>
                        <td>5</td>
                        <td>Rp 50.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel 2: Laporan Stok -->
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
                        <th>Stok Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#101</td>
                        <td>Kopi</td>
                        <td>100</td>
                        <td>40</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td>#102</td>
                        <td>Teh</td>
                        <td>200</td>
                        <td>70</td>
                        <td>130</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
