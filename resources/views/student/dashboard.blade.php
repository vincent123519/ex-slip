<!DOCTYPE html>
@extends('components.stud')

@section('content')
    <div class="student-details-container">
        <h1>Absence Request</h1>
        <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Request Excuse Slip</a>
        <div class="manage-slip-container">
            <h2>Excuse Slips</h2>

            @foreach($excuseSlips as $excuseSlip)
                <tr>
                    <td>{{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</td>
                    <td>{{ $excuseSlip->status_id }}</td>
                    <!-- Add other table cells as needed -->
                </tr>
            @endforeach
                <p>++++++++++++++++++++++++++++++++++</p>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('start_date') && session('end_date'))
                        <br>
                        <strong>Excuse Slip Dates:</strong> {{ session('start_date') }} to {{ session('end_date') }}
                    @endif
                </div>
            @endif
        </div>
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

    .create-slip-button {
        display: inline-block;
        padding: 10px 15px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        background-color: #28a745; /* Green color */
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s;
        border: 1px solid #218838; /* Darker green color */
    }

    .create-slip-button:hover {
        background-color: #218838;
    }

    .excuse-slip {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .excuse-slip p {
        margin-bottom: 5px;
    }
</style>