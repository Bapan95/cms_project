<!-- resources/views/errors/403.blade.php -->
@extends('layouts.app')

@section('title', 'Forbidden')

@section('content')
    <h1 class="text-2xl font-bold mb-4">403 Forbidden</h1>
    <p>You do not have permission to access this page.</p>
    <a href="{{ route('articles.index') }}" class="bg-blue-500 text-white p-2 rounded">Go Back to Articles</a>
@endsection
