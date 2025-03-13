<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield("title")
    <link rel="stylesheet" href="css/navbar.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }
    </script>
</head>
<body class="flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <button class="close-btn" onclick="toggleSidebar()">×</button>
        <div class="profile">
            <img src="storage/profile.jpg" alt="Profile Picture">
            <h2>putra</h2>
            <p>Admin Kasir</p>
        </div>
        <nav>
            <ul>
                <li><a href="/"><i class="ph ph-house"></i> Dashboard</a></li>
                <li><a href="/produk"><i class="ph ph-package"></i> Produk</a></li>
                <li><a href="/laporan"><i class="ph ph-chart-bar"></i> Laporan</a></li>
                <li><a href="/pengaturan"><i class="ph ph-gear"></i> Pengaturan</a></li>
            </ul>
        </nav>
        <form method="post" class="logout-form" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <button class="menu-btn" onclick="toggleSidebar()">☰</button>
        @yield("content")
    </div>
</body>
</html>
