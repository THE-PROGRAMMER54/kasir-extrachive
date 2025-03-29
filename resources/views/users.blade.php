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

    <div class="table-container">
        <table class="produk-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Foto Profile</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $user)
                    @if ($user->id != auth()->user()->id)
                        <tr>
                            <td>{{ $loop->iteration -1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td><img src="{{ asset("storage/".$user->gambar) }}" alt="foto profile" style="height: 70px;"></td>
                            <td>
                                <div class="action-wrapper">
                                    <button class="btn edit" data-id={{ $user->id }} ><i class="ph ph-pencil"></i> </button>
                                    <form action="{{ route('deleteuserakun', $user->id) }}" method="post" onsubmit="return confirm('Apakah anda yakin akan menghapus user ini?')">
                                        @csrf
                                        <button class="btn delete"><i class="ph ph-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" style="padding: 20px;">Tidak ada Users</td>
                    </tr>
                @endforelse
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

    @foreach ($data as $user)
        {{-- form overlay stok produk --}}
        <div class="overlay" id="formedit-{{ $user->id }}">
            <div class="form-container">
                <h3>Edit User</h3>
                <form id="rolefrom" method="post" enctype="multipart/form-data" action="{{ route("editdatauser",$user->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">name:</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}">
                    </div>

                    <div class="form-group">
                        <label for="email">email:</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}">
                    </div>

                    <div class="form-group">
                        <label for="role">role:</label>
                        <select name="role" id="role">
                            <option value="super admin" {{ $user->role == "super admin" ? "selected" : "" }}>super admin</option>
                            <option value="admin" {{ $user->role == "admin" ? "selected" : "" }}>admin</option>
                            <option value="kasir" {{ $user->role == "kasir" ? "selected" : "" }}>kasir</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gambar">Gambar Produk:</label>
                        <input type="file" id="gambar" name="gambar">
                        @if (file_exists(public_path('storage/'.$user->gambar)))
                            <img id="preview" src="{{ asset("storage/".$user->gambar) }}" alt="Pratinjau Gambar">
                        @else
                            <img id="preview" src="" alt="Pratinjau Gambar" style="display: none;">
                        @endif
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
        // gambar
        document.getElementById("gambar").addEventListener("change",function(){
            if (this.files.length > 0) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("preview").src = e.target.result;
                    document.getElementById("preview").style.display = "block";
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                document.getElementById("preview").style.display = "none";
            }
        })

        // Form edit user
        let stokButtons = document.querySelectorAll(".btn.edit");
        stokButtons.forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                let formedit = document.getElementById("formedit-" + id);
                if (formedit) {
                    formedit.style.display = "flex";
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
