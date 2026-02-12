@extends('layouts.app')

@section('title', 'Classes')

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-lg font-bold mb-4">Class List</h3>
            <ul class="list-disc pl-5">
                @forelse($classes as $class)
                    <li>{{ $class->name }} ({{ $class->students_count ?? 0 }} students)</li>
                @empty
                    <li>No classes found.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection