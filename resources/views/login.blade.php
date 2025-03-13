<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        @if (session('error-login'))
            <div class="pesan-error">{{ session('error-login') }}</div>
        @endif
        <form action="{{ route('proseslogin') }}" method="POST">
            @csrf
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

            <!-- Tombol Login -->
            <button type="submit">Login</button>
        </form>

        <!-- Link Registrasi -->
        <p class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
