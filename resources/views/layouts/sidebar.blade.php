<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-graduation-cap"></i>
        <span>R-System</span>
    </div>
    
    <nav class="sidebar-menu">
        <ul>
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            
            <li class="menu-header">Academic</li>
            
            @if(auth()->check() && auth()->user()->role === 'student')
            <li class="{{ request()->is('report/student*') ? 'active' : '' }}">
                <a href="{{ action([App\Http\Controllers\ReportCardController::class, 'generateForStudent']) }}" target="_blank">
                    <i class="fas fa-file-alt"></i> <span>My Report Card</span>
                </a>
            </li>
            @endif

            @if(auth()->check() && (auth()->user()->role === 'teacher' || auth()->user()->role === 'admin'))
            <li class="{{ request()->is('classes*') ? 'active' : '' }}">
                <a href="{{ url('/classes') }}">
                    <i class="fas fa-chalkboard-teacher"></i> <span>Class Management</span>
                </a>
            </li>
            @endif

            <li class="menu-header">System</li>
            
            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" onclick="document.getElementById('logout-form').submit()">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </nav>
</aside>