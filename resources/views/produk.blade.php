@extends("navbar")
@section("title")
    <title>Produk</title>
    <link rel="stylesheet" href="css/produk.css">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
@endsection

@section("content")
<div class="container">
    <h1 class="page-title">Data Produk</h1>

    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'super admin')
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
                    <th>Diskon</th>
                    <th>Gambar Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            @forelse ($data as $barang)
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        @if ($barang->diskon != 0)
                            <td>Rp {{ number_format($barang->hasil_diskon,'0',',','.') }}</td>
                        @else
                            <td>Rp {{ number_format($barang->harga,'0',',','.') }}</td>
                        @endif
                        <td>{{ number_format($barang->stok,'0',',','.') }}</td>
                        <td>{{ $barang->diskon }}%</td>
                        <td>
                            <img src="{{ asset('storage/'.$barang->gambar) }}" style="height: 80px; width= 80px; padding: 0;" alt="Gambar Produk">
                        </td>
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'super admin')
                            <td>
                                <div class="action-wrapper">
                                    <button class="btn stok" data-id={{ $barang->kode_barang }}><i class="ph ph-plus-circle"></i></button>
                                    <button class="btn edit" data-id={{ $barang->kode_barang }}><i class="ph ph-pencil"></i> </button>
                                    <form action="{{ route('deleteproduk',$barang->kode_barang) }}" method="post" onsubmit="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                        @csrf
                                        <button class="btn delete"><i class="ph ph-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="action-wrapper">
                                    <button class="btn stok" data-id={{ $barang->kode_barang }}>Tambah Stok</button>
                                </div>
                            </td>
                        @endif
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr>
                        <td colspan="{{ in_array(auth()->user()->role, ['admin','super admin'])? 6 : 5 }}" class="text-center">Tidak ada data produk</td>
                    </tr>
                </tbody>
            @endforelse
        </table>
    </div>

    @if (session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    {{-- form overlay tambah produk --}}
    <div class="overlay" id="formTambah">
        <div class="form-container">
            <h3>Tambah Produk</h3>
            <form id="produkForm" method="post" action="{{ route('tporduk') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama_barang">Nama Produk:</label>
                    <input type="text" id="nama_barang" name="nama_barang" required>
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
                    <label for="diskon">Diskon:</label>
                    <input type="number" id="diskon" name="diskon" min="0" max="100" required>
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

    @foreach ($data as $barang)
    {{-- form overlay edit produk --}}
    <div class="overlay" id="formEdit-{{ $barang->kode_barang }}">
        <div class="form-container">
            <h3>Edit Produk</h3>
            <form id="produkForm" enctype="multipart/form-data" action="{{ route('eporduk',$barang->kode_barang) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nama_barang">Nama Produk:</label>
                    <input type="text" value="{{ $barang->nama_barang }}" id="nama_barang" name="nama_barang">
                </div>

                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" id="harga" value="{{ $barang->harga }}" name="harga">
                </div>

                <div class="form-group">
                    <label for="diskon">Diskon:</label>
                    <input type="number" id="diskon" value="{{ $barang->diskon }}" min="0" max="100" name="diskon">
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

    {{-- form overlay stok produk --}}
    <div class="overlay" id="formstok-{{ $barang->kode_barang }}">
        <div class="form-container">
            <h3>Tambah Stok</h3>
            <form id="produkForm" method="post" action="{{ route('tstok',$barang->kode_barang) }}">
                @csrf
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <input type="number" id="stok" name="stok">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan</button>
                    <button type="button" class="btn btn-cancel" id="batal">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Form tambah produk
        let tambahButton = document.querySelector(".btn.tambah");
        if (tambahButton) {
            tambahButton.addEventListener("click", function () {
                document.getElementById("formTambah").style.display = "flex";
            });

            document.querySelector("#formTambah .btn-cancel").addEventListener("click", function () {
                document.getElementById("formTambah").style.display = "none";
            });

            document.getElementById("gambar").addEventListener("change", function (event) {
                let file = event.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let preview = document.getElementById("preview");
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Form edit produk
        let editButtons = document.querySelectorAll(".btn.edit");
        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                let formEdit = document.getElementById("formEdit-" + id);
                if (formEdit) {
                    formEdit.style.display = "flex";
                }
            });
        });

        // Form tambah stok
        let stokButtons = document.querySelectorAll(".btn.stok");
        stokButtons.forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                let formStok = document.getElementById("formstok-" + id);
                if (formStok) {
                    formStok.style.display = "flex";
                }
            });
        });

        // Tombol batal untuk semua overlay
        let cancelButtons = document.querySelectorAll(".btn-cancel");
        cancelButtons.forEach(button => {
            button.addEventListener("click", function () {
                this.closest(".overlay").style.display = "none";
            });
        });
    });
</script>
@endsection
