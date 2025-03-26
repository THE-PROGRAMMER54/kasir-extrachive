@extends("navbar")
@section("title")
    <title>Users</title>
    <link rel="stylesheet" href="css/user.css">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
@endsection

@section("content")
<div class="container">
    <h1 class="page-title">Data Users</h1>

    @if (auth()->user()->role === 'super admin')
    <div class="action-buttons">
        <button class="btn tambah">+ Tambah Produk</button>
    </div>
    @endif

    <div class="table-container">
        <table class="produk-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Foto Profile</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" style="padding: 20px;">Tidak ada Users</td>
                    <td>
                        <div class="action-wrapper">
                            <button class="btn edit" data-id=><i class="ph ph-pencil"></i> </button>
                            <form action="" method="post" onsubmit="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                @csrf
                                <button class="btn delete"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
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

    {{-- form overlay stok produk --}}
    <div class="overlay" id="formstok-">
        <div class="form-container">
            <h3>Edit Role</h3>
            <form id="produkForm" method="post" action="">
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
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
