@extends('layouts.app')
@section('title', 'Manage Classes')
@section('content')
<div class="content-container">
    <div class="management-card">
        <div class="card-header-actions">
            <h2 class="management-title">Manage Classes</h2>
            <div class="header-btns">
                <a href="{{ route('admin.classes.import.show') }}" class="btn-secondary">
                    <i class="fas fa-file-import"></i> Import
                </a>
                <a href="{{ route('admin.classes.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Class
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form method="GET" action="{{ route('admin.classes.index') }}">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" placeholder="Search by Class Name..." class="search-field" value="{{ request('search') }}">
                </div>

            {{-- Display Messages --}}
            <x-success-message />
            <x-error-message />

            {{-- Classes Table --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Academic Session</th>
                            <th scope="col" class="px-6 py-3">Enrolled Students</th>
                            <th scope="col" class="px-6 py-3">Subjects & Teachers</th>
                            <th scope="col" class="px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $class)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $class->name }}</th>
                                <td class="px-6 py-4">{{ $class->academicSession->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $class->students_count }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($class->subjects as $subject)
                                            <span class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                                {{ $subject->name }}
                                                @if ($subject->pivot->teacher_id)
                                                    <span class="font-semibold ml-1">({{ \App\Models\User::find($subject->pivot->teacher_id)->name ?? 'N/A' }})</span>
                                                @endif
                                            </span>
                                        @empty
                                            <span class="text-xs italic text-gray-400 dark:text-gray-500">No subjects assigned</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{-- NEW ACTION BUTTONS --}}
                                    <div class="flex justify-end items-center space-x-4">
                                        {{-- Link to the powerful Edit page --}}
                                        <a href="{{ route('admin.classes.edit', $class) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit & Assign</a>
                                        {{-- Link to the Enrollment page --}}
                                        <a href="{{ route('admin.classes.enroll.index', $class) }}" class="font-medium text-green-600 dark:text-green-500 hover:underline">Enroll Students</a>
                                        {{-- Standard Delete Form --}}
                                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No classes found.
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-4">
                {{-- This makes the pagination links work with the search query --}}
                {{ $classes->withQueryString()->links() }}
            </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="10%">CLASS</th>
                        <th width="15%">SESSION</th>
                        <th width="10%">ENROLLED</th>
                        <th width="45%">SUBJECTS & TEACHERS</th>
                        <th width="20%" style="text-align: right;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr>
                        <td class="class-name-cell">{{ $class->name }}</td>
                        <td class="text-muted">{{ $class->academicSession->name ?? 'N/A' }}</td>
                        <td>
                            <span class="count-badge">{{ $class->students_count }}</span>
                        </td>
                        <td>
                            <div class="subject-tag-cloud">
                                @forelse($class->subjects as $subject)
                                    <span class="subject-pill" title="{{ $subject->pivot->teacher_id ? 'Teacher Assigned' : 'No Teacher' }}">
                                        {{ $subject->name }}
                                    </span>
                                @empty
                                    <span class="text-dimmed">No subjects assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-group">
                                <a href="{{ route('admin.classes.edit', $class) }}" title="Edit & Assign" class="act-btn btn-blue"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.classes.enroll.index', $class) }}" title="Enroll Students" class="act-btn btn-green"><i class="fas fa-user-plus"></i></a>
                                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Delete this class?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" class="act-btn btn-red"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">No classes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Spacing -->
        <div style="margin-top: 20px; color: #94a3b8;">
            {{ $classes->withQueryString()->links() }}
        </div>
    </div>
</x-app-flowbite-layout>
</div>
@endsection