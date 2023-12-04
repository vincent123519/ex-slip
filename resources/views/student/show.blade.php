
@extends('components.layout')

@section('content')
    <div class="student-details-container">
        <h1>{{ $student->name }}</h1>
        <p>Degree Program: {{ $student->degree_id }}</p>
        <p>Year Level: {{ $student->year_level }}</p>

        {{-- Button to Request Excuse Slip --}}
        <a href="{{ route('students.request_excuse_slip', $student->id) }}" class="btn btn-primary">Request Excuse Slip</a>
    </div>
@endsection

<style>
    .student-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 5px;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
