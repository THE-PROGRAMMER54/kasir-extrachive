<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield("title")
    <link rel="stylesheet" href="css/navbar.css">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
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
            @if (asset(public_path('storage/'.auth()->user()->gambar)))
                <img src="{{ asset('storage/'.auth()->user()->gambar) }}" alt="gambar">
            @else
                <img src="storage/profile.jpg" alt="Profile Picture">
            @endif
            <h2>{{ auth()->user()->name }}</h2>
            <p>{{ auth()->user()->role }}</p>
        </div>
        <nav>
            <ul>
                @if (auth()->user()->role == 'kasir')
                    <li><a href="{{ route('kasir') }}"><i class="ph ph-cash-register"></i> Kasir</a></li>
                    <li><a href="{{ route('produk') }}"><i class="ph ph-package"></i> Produk</a></li>
                    <li><a href="{{ route('pengaturan') }}"><i class="ph ph-gear"></i> Pengaturan</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}"><i class="ph ph-house"></i> Dashboard</a></li>
                    @if (auth()->user()->role == 'super admin')
                        <li><a href="{{ route('users') }}"><i class="ph ph-users"></i> Users</a></li>
                    @endif
                    <li><a href="{{ route('kasir') }}"><i class="ph ph-cash-register"></i> Kasir</a></li>
                    <li><a href="{{ route('produk') }}"><i class="ph ph-package"></i> Produk</a></li>
                    <li><a href="{{ route('laporan') }}"><i class="ph ph-chart-bar"></i> Laporan</a></li>
                    <li><a href="{{ route('pengaturan') }}"><i class="ph ph-gear"></i> Pengaturan</a></li>
                @endif
            </ul>

        </nav>
        <form method="post" class="logout-form" action="{{ route('logout') }}" onclick="return confirm('apakah kamu yakin ingin logout?')">
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
