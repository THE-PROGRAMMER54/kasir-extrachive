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
            <div class="foto-container">
                <img id="gambar" src="storage/profile.jpg" alt="Foto Profil">
                <input type="file" id="fileInput" name="gambar" hidden>
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

<script>
    document.addEventListener('DOMContentLoaded',function(){
        const fileInput = document.getElementById('fileInput');
        const gambar = document.getElementById('gambar');

        if(!fileInput ||!gambar){
            console.log('gambar tidak ditemukan');
            return;
        }

        gambar.addEventListener('click',function(){
            console.log("img di klik");
            fileInput.click();
        })

        fileInput.addEventListener('change',function(){
            if(this.files.length > 0){
                console.log('gambar di pilih:',this.files[0].name);
                const reader = new FileReader();
                reader.onload = function(e){
                    gambar.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        })
    })
</script>
