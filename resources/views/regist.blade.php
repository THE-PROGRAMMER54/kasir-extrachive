<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h2>Registrasi</h2>
        @if (session('error-regist'))
            <div class="pesan-error">{{ session('error-regist') }}</div>
        @endif
        <form action="{{ route('prosesregist') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Upload Foto -->
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="gambar">
            </div>

            <!-- Nama -->
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" placeholder="Masukkan Nama" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password" placeholder="Ulangi Password" required>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit">Daftar</button>
        </form>

        <!-- Link Login -->
        <p class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </div>
</body>
</html>
