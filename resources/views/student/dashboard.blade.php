<!-- resources/views/student/dashboard.blade.php -->

@extends('layouts.app') <!-- Assuming you have a main layout file -->

@section('content')
    <div class="container">
        <h1>Welcome to Your Dashboard, {{ $student->name }}!</h1>

        <!-- Add your dashboard content here -->

    </div>
@endsection
