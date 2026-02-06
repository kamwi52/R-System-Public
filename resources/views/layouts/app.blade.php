<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'R-System')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Using FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-wrapper">
        @include('layouts.sidebar')
        
        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button id="sidebar-toggle"><i class="fas fa-bars"></i></button>
                    <h2 class="page-title">@yield('title', 'Dashboard')</h2>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                        <div class="avatar-circle">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.app-wrapper').classList.toggle('sidebar-collapsed');
        });
    </script>
</body>
</html>