<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name', 'LMS Dashboard') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- 🔹 Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- 🔹 Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-light: #f8f9fa;
            --bg-dark: #1c1c1c;
            --text-light: #f8f9fa;
            --text-dark: #212529;
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-family: "Poppins", sans-serif;
            transition: var(--transition);
        }

        /* 🌙 Dark mode styles */
        body.dark-mode {
            background-color: var(--bg-dark);
            color: var(--text-light);
        }
        body.dark-mode .navbar {
            background-color: #121212 !important;
        }
        body.dark-mode .card,
        body.dark-mode .alert {
            background-color: #2b2b2b;
            color: var(--text-light);
            border-color: #3b3b3b;
        }
        body.dark-mode a,
        body.dark-mode .nav-link {
            color: #e0e0e0 !important;
        }

        /* 🔹 Navbar */
        .navbar {
            background: #0d6efd !important;
            transition: var(--transition);
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .nav-link {
            color: #fff !important;
            transition: var(--transition);
        }
        .nav-link:hover, .nav-link.active {
            color: #ffc107 !important;
            transform: translateY(-1px);
        }

        /* 🔹 Flash Messages */
        .alert {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* 🔹 Dark mode toggle */
        #theme-toggle {
            background: transparent;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        #theme-toggle:hover {
            transform: rotate(20deg);
        }

        /* 🔹 Smooth transitions for cards and links */
        .transition {
            transition: var(--transition);
        }
        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-light">

    {{-- 🔹 Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('courses.index') }}">
                <i class="fa fa-book me-2"></i> LMS
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                    aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

                    {{-- 🔹 Courses --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('courses') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                            <i class="fa fa-layer-group me-1"></i> Courses
                        </a>
                    </li>

                    {{-- 🔹 My Courses (Authenticated Users Only) --}}
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('my-courses*') ? 'active' : '' }}" href="{{ route('courses.my') }}">
                                <i class="fa fa-graduation-cap me-1"></i> My Courses
                            </a>
                        </li>
                    @endauth

                    {{-- 🔹 Theme Toggle --}}
                    <li class="nav-item">
                        <button id="theme-toggle" class="nav-link">
                            <i class="fa fa-moon"></i>
                        </button>
                    </li>

                    {{-- 🔹 Auth Buttons --}}
                    @auth
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="fa fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">
                                <i class="fa fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    {{-- 🔹 Flash Messages + Page Content --}}
    <div class="container mb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @elseif (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @yield('content')
    </div>

    {{-- 🔹 Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 🌗 Dark Mode Toggle Script --}}
    <script>
        const toggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = toggle.querySelector('i');

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            icon.classList.replace('fa-moon', 'fa-sun');
        }

        toggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            icon.classList.toggle('fa-moon', !isDark);
            icon.classList.toggle('fa-sun', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    </script>

    @stack('scripts')
</body>
</html>
