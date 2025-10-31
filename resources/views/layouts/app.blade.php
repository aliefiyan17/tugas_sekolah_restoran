<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kasir Restoran')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script> {{-- kalau kamu pakai Tailwind juga --}}
    @stack('styles') {{-- <<< tambahkan ini --}}
</head>
<body class="bg-[#F5F5F5]">
    <nav class="bg-[#333333] text-white shadow-lg ">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold ">Kasir Restoran</h1>
                    @auth
                        <span class="bg-gray-500 px-3 py-1 rounded text-sm">{{ ucfirst(auth()->user()->role) }}</span>
                    @endauth
                </div>
                
                @auth
                <div class="flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-200">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    
                    @if(auth()->user()->isAdministrator())
                        <a href="{{ route('menu.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-utensils mr-2"></i>Menu
                        </a>
                        <a href="{{ route('meja.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-chair mr-2"></i>Meja
                        </a>
                        <a href="{{ route('pelanggan.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-users mr-2"></i>Pelanggan
                        </a>
                    @endif
                    
                    @if(auth()->user()->isWaiter())
                        <a href="{{ route('pesanan.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-clipboard-list mr-2"></i>Pesanan
                        </a>
                    @endif
                    
                    @if(auth()->user()->isKasir())
                        <a href="{{ route('transaksi.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-cash-register mr-2"></i>Transaksi
                        </a>
                    @endif
                    
                    @if(auth()->user()->isWaiter() || auth()->user()->isKasir() || auth()->user()->isOwner())
                        <a href="{{ route('laporan.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-chart-line mr-2"></i>Laporan
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        <p>&copy; 2024 Aplikasi Kasir Restoran. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>