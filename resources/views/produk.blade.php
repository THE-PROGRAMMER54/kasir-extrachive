@extends("navbar")
@section("title")
    <title>Produk</title>
    <link rel="stylesheet" href="css/produk.css">
@endsection

@section("content")
<div class="container">
    <h1 class="page-title">Data Produk</h1>

    <div class="action-buttons">
        <button class="btn tambah">+ Tambah Produk</button>
    </div>

    <div class="table-container">
        <table class="produk-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>001</td>
                    <td>Kopi</td>
                    <td>Rp 20.000</td>
                    <td>50</td>
                    <td>
                        <div class="action-wrapper">
                            <button class="btn edit">Edit</button>
                            <button class="btn delete">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Teh</td>
                    <td>Rp 10.000</td>
                    <td>100</td>
                    <td>
                        <div class="action-wrapper">
                            <button class="btn edit">Edit</button>
                            <button class="btn delete">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>Roti</td>
                    <td>Rp 30.000</td>
                    <td>25</td>
                    <td>
                        <div class="action-wrapper">
                            <button class="btn edit">Edit</button>
                            <button class="btn delete">Hapus</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
