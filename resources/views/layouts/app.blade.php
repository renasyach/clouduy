<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Anggota Kelompok') - Clouduy</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Website profil anggota kelompok Clouduy. Menampilkan data identitas lengkap beserta foto dari setiap anggota kelompok.">
    <meta name="author" content="Clouduy Team">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="app-container">
        
        <!-- Header / Navigation -->
        <header>
            <div class="nav-wrapper">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fa-solid fa-cloud"></i> Clouduy
                </a>
                
                <ul class="nav-links">
                    <li>
                        <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                            <i class="fa-solid fa-users"></i> Anggota
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') || Route::is('members.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-gauge"></i> Kelola
                            </a>
                        </li>
                        <li>
                            <span class="nav-link" style="color: var(--text-muted); cursor: default;">
                                <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-right-to-bracket"></i> Masuk Admin
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </header>

        <!-- Main Content Section -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            <p>&copy; {{ date('Y') }} <a href="{{ route('home') }}">Clouduy Team</a>. Semua hak dilindungi undang-undang.</p>
        </footer>

    </div>

    <!-- Scripts Section -->
    @yield('scripts')

</body>
</html>
