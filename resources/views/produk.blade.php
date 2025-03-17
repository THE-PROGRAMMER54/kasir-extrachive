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
                    <th>Aksi</th>
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
                                    <button class="btn edit" data-id={{ $barang->kode_barang }}>Edit</button>
                                    <button class="btn stok"data-id={{ $barang->kode_barang }}>Stok</button>
                                    <button class="btn delete">Hapus</button>
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="action-wrapper">
                                    <button class="btn stok" data-id="{{ $barang->kode_barang }}">Tambah Stok</button>
                                </div>
                            </td>
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

{{-- form overlay tambah produk --}}
<div class="overlay" id="formTambah">
    <div class="form-container">
        <h3>Tambah Produk</h3>
        <form id="produkForm">
            <div class="form-group">
                <label for="nama">Nama Produk:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Produk:</label>
                <input type="file" id="gambar" name="gambar" required>
                <img id="preview" src="" alt="Pratinjau Gambar" style="display: none;">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <button type="button" class="btn btn-cancel" id="batal">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- form overlay edit produk --}}
<div class="overlay" id="formEdit-{{ $barang->kode_barang }}">
    <div class="form-container">
        <h3>Edit Produk</h3>
        <form id="produkForm">
            <div class="form-group">
                <label for="nama">Nama Produk:</label>
                <input type="text" value="{{ $barang->nama_barang }}" id="nama" name="nama">
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" value="{{ $barang->harga }}" name="harga">
            </div>

            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" value="{{ $barang->stok }}" id="stok" name="stok">
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Produk:</label>
                <input type="file" id="gambar" name="gambar">
                <img id="preview" src="{{ asset('storage/'.$barang->gambar) }}" alt="Pratinjau Gambar">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <button type="button" class="btn btn-cancel" id="batal">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- form overlay edit produk --}}
<div class="overlay" id="formstok-{{ $barang->kode_barang }}">
    <div class="form-container">
        <h3>Tambah Stok</h3>
        <form id="produkForm">
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" value="{{ $barang->stok }}" id="stok" name="stok">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <button type="button" class="btn btn-cancel" id="batal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // form tambah
        document.querySelector(".btn.tambah").addEventListener("click", function() {
            document.getElementById("formTambah").style.display = "flex";
        });

        document.getElementById("batal").addEventListener("click", function() {
            document.getElementById("formTambah").style.display = "none";
        });

        document.getElementById("gambar").addEventListener("change", function() {
            let file = event.target.files[0];
            if(file){
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("preview").src = e.target.result;
                    document.getElementById("preview").style.display = "block";
                }
                reader.readAsDataURL(file);
            }
        })

    // edit produk
    document.querySelectorAll(".btn.edit").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let formEdit = document.getElementById("formEdit-" + id);

            if (formEdit) {
                formEdit.style.display = "flex";
            }
        });
    });

    document.querySelectorAll(".btn-cancel").forEach(button => {
        button.addEventListener("click", function () {
            this.closest(".overlay").style.display = "none";
        });
    });

    // stok produk
    document.querySelectorAll(".btn.stok").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let formStok = document.getElementById("formstok-" + id);

            if (formStok) {
                formStok.style.display = "flex";
            }
        });
    });
    document.querySelectorAll(".btn-cancel").forEach(button => {
        button.addEventListener("click", function () {
            this.closest(".overlay").style.display = "none";
        });
    });
</script>
@endsection
