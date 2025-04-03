@extends("navbar")
@section("title")
    <title>Pengaturan Akun</title>
    <link rel="stylesheet" href="css/pengaturan.css">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
@endsection

@section("content")
<div class="container">
    <h2>Pengaturan Akun</h2>

    <!-- Ganti Foto Profil -->
    <div class="profile-section">
        <div class="profile-picture">
            @if (file_exists(public_path('storage/'. auth()->user()->gambar)))
                <img src="{{ asset('storage/'. auth()->user()->gambar) }}" alt="Foto Profil" id="profile-img">
                <div class="camera-icon" onclick="toggleMenu()">
                    <i class="ph ph-camera"></i>
                </div>
            @else
                <img src="storage/profile.jpg" alt="Foto Profil" id="profile-img">
                <div class="camera-icon" onclick="toggleMenu()">
                    <i class="ph ph-camera"></i>
                </div>
            @endif
        </div>
        <div class="photo-menu" id="photo-menu">
            <form action="{{ route("updatephoto",['id' => auth()->user()->id ])}}" enctype="multipart/form-data" method="post" id="gambar_edit">
                @csrf
                <input type="file" name="gambar" id="gambar" hidden>
                <button type="button" id="btnsubmit">Ganti Foto</button>
            </form>
            <form action="{{ route('deletephoto',["id" => auth()->user()->id ]) }}" method="post">
                @csrf
                <button type="submit">Hapus Foto</button>
            </form>
        </div>
    </div>

    <!-- Ganti Username & Email -->
    <div class="form-section">
        <h3>Ganti Username & Email</h3>
        <form method="post" action="{{ route("edituser",["id" => auth()->user()->id ]) }}">
            @csrf
            <label>Username</label>
            <input type="text" name="name" placeholder="Masukkan username baru">

            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email baru">

            <button class="btninput" type="submit">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Ganti Password -->
    <div class="form-section">
        <h3>Ganti Password</h3>
        <form method="post" action="{{ route("editpass",["id" => auth()->user()->id ]) }}">
            @csrf
            <label>Password Lama</label>
            <input type="password" name="password" placeholder="Masukkan password lama">

            <label>Password Baru</label>
            <input type="password" name="new-pass" placeholder="Masukkan password baru">

            <label>Konfirmasi Password</label>
            <input type="password" name="confirm-pass" placeholder="Ulangi password baru">

            <button class="btninput" type="submit">Ubah Password</button>
        </form>
    </div>

    <!-- Hapus Akun -->
    <div class="form-section delete-section">
        <h3>Hapus Akun</h3>
        <p><strong>Peringatan:</strong> Jika Anda menghapus akun, semua data Anda akan hilang secara permanen.</p>
        <form action="{{ route("deleteakun",["id" => auth()->user()->id ]) }}" onsubmit="return confirm('apakah anda yakin akan menghapus akun anda??')" method="post">
            @csrf
            <button class="delete-btn">Hapus Akun</button>
        </form>
    </div>
</div>

@endsection
@if (session("error"))
    <script>
        alert('{{ session("error") }}');
    </script>
@endif

@if (session("success"))
    <script>
        alert('{{ session("success") }}');
    </script>
@endif

<script>
    function toggleMenu() {
        const menu = document.getElementById("photo-menu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    document.getElementById("btnsubmit").addEventListener("click",function(){
        document.getElementById("gambar").click();
    })

    document.getElementById("gambar").addEventListener("change",function(){
        if (this.files.length > 0) {
            document.getElementById("gambar_edit").submit();
        }
    })
</script>
