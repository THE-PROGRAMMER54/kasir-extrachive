@extends("navbar")
@section("title")
    <title>Pengaturan Akun</title>
    <link rel="stylesheet" href="css/pengaturan.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/css/phosphor.css">
@endsection

@section("content")
<div class="container">
    <h2>Pengaturan Akun</h2>

    <!-- Ganti Foto Profil -->
    <div class="profile-section">
        <div class="profile-picture">
            <img src="storage/profile.jpg" alt="Foto Profil" id="profile-img">
            <div class="camera-icon" onclick="toggleMenu()">
                <i class="ph ph-camera"></i>
            </div>
        </div>
        <div class="photo-menu" id="photo-menu">
            <button>Ganti Foto</button>
            <button>Hapus Foto</button>
        </div>
    </div>

    <!-- Ganti Username & Email -->
    <div class="form-section">
        <h3>Ganti Username & Email</h3>
        <form>
            <label>Username</label>
            <input type="text" placeholder="Masukkan username baru">

            <label>Email</label>
            <input type="email" placeholder="Masukkan email baru">

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Ganti Password -->
    <div class="form-section">
        <h3>Ganti Password</h3>
        <form>
            <label>Password Lama</label>
            <input type="password" placeholder="Masukkan password lama">

            <label>Password Baru</label>
            <input type="password" placeholder="Masukkan password baru">

            <label>Konfirmasi Password</label>
            <input type="password" placeholder="Ulangi password baru">

            <button type="submit">Ubah Password</button>
        </form>
    </div>

    <!-- Hapus Akun -->
    <div class="form-section delete-section">
        <h3>Hapus Akun</h3>
        <p><strong>Peringatan:</strong> Jika Anda menghapus akun, semua data Anda akan hilang secara permanen.</p>
        <button class="delete-btn" onclick="confirmDelete()">Hapus Akun</button>
    </div>
</div>

<script>
    // Toggle menu foto
    function toggleMenu() {
        const menu = document.getElementById("photo-menu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }
</script>
@endsection
