<li>
    <a href="{{ route('admin.users.index') }}" class="{{ Request::is('admin/users*') ? 'active' : '' }}"><i class="fas fa-users"></i>User Management</a>
</li>
<li>
    <a href="{{ route('admin.grading-scales.index') }}" class="{{ Request::is('admin/grading-scales*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i>Grading Scales</a>
</li>