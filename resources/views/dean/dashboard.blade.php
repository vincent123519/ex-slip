@extends('components.dean')
@section('content')
    <div class="dean-details-container">
        <h1>Absence Request</h1>
        <hr>
        <a href="" class="create-slip-button"> Number of Excuse slip</a>
        <h2>Excuse Slips</h2>
        @if(count($excuseSlips) > 0)
                <table class="excuse-slip-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Duration day</th>
                            <th>Counselor Feedback</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($excuseSlips as $excuseSlip)
                            <tr>
                                <td>{{ $excuseSlip->student_id}}</td>
                                <td>{{ $excuseSlip->student->name}}</td>
                                <td>{{ $excuseSlip->status_id }}</td>
                                <td>{{ $excuseSlip->start_date->format('m-d-Y') }} - {{ $excuseSlip->end_date->format('m-d-Y') }}</td>
                                <td> {{ $excuseSlip->start_date->format('l') }} - {{ $excuseSlip->end_date->format('l') }}
                                ({{ $excuseSlip->start_date->diffInDays($excuseSlip->end_date) }} days)</td>
                                <td>{{ $excuseSlip->counselors_feedback }}</td>
                                <!-- Add other table cells as needed -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No Excuse Slips found.</p>
            @endif

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
    .dean-details-container {
    background-color: #f8f9fa;
    padding: 30px;
    border: 10px solid #55825f;
    border-radius: 10px;
    width: 60%;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    hr{
        height: 1px;
        background-color: darkgreen;
        border: 2px solid black;
        border-radius: 10px;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    hr:hover{
    
    height: 2px;
    background-color: green;
    border: 1px solid black;
    width: 100%;
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

    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th,
    .excuse-slip-table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    .excuse-slip-table th {
        background-color: #f8f9fa;
    }


</style>
