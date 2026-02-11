<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'R-System')</title> 
    <!-- Using FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])

</head>
<body>
    <div class="app-wrapper">
        @include('layouts.sidebar')
        
        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button id="sidebar-toggle"><i class="fas fa-bars"></i></button>
                    @if(isset($header))
                        {{ $header }}
                    @else
                        <h2 class="page-title">@yield('title', 'Dashboard')</h2>
                    @endif
                </div>
                <div class="header-right">
                    <button id="theme-toggle" class="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="user-profile">
                        <span>{{ Auth::user()?->name ?? 'Guest' }}</span>
                        <div class="avatar-circle">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-body">
                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.app-wrapper').classList.toggle('sidebar-collapsed');
        });

        // Dark Mode Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        
        // Check initial preference
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }

        themeToggleBtn.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('color-theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            } else {
                localStorage.setItem('color-theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        });
    </script>
</body>
</html>