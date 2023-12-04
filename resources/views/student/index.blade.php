@extends('layouts.app')  {{-- Assuming you have a layout file --}}

@section('content')
    <div class="container">
        <h1>Student Information</h1>

        <div>
            <strong>User ID:</strong> {{ $student->user_id }}
        </div>

        <div>
            <strong>Name:</strong> {{ $student->name }}
        </div>

        <div>
            <strong>Degree ID:</strong> {{ $student->degree_id }}
        </div>

        <div>
            <strong>Year Level:</strong> {{ $student->year_level }}
        </div>

        {{-- Add more details as needed based on your database structure --}}

        <div>
            {{-- Add additional information based on your database structure --}}
        </div>

        <a href="{{ route('students.index') }}" class="btn btn-primary">Back to Student List</a>
    </div>
@endsection
