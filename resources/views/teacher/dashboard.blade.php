@extends('components.teacher')
@section('content')
    <div class="teacher-details-container">
        <h1>Absence Request</h1>
        <a href="" class="create-slip-button"> Number of Excuse slip</a>
        <h2>Excuse Slips</h2>
            @if($excuseSlips->count() > 0)
            <table class="excuse-slip-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Duration day</th>
                           
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($excuseSlips as $excuseSlip)
                            <tr>
                                <td>{{ $excuseSlip->student->first_name}} {{ $excuseSlip->student->last_name}}</td>
                                <td>{{ $excuseSlip->status->status_name }}</td>
                                <td>{{ $excuseSlip->start_date->format('m-d-Y') }} - {{ $excuseSlip->end_date->format('m-d-Y') }}</td>
                                <td> {{ $excuseSlip->start_date->format('l') }} - {{ $excuseSlip->end_date->format('l') }}
                                ({{ $excuseSlip->start_date->diffInDays($excuseSlip->end_date) }} days)</td>
                                <td width="300">
                                    
                                    <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $excuseSlip->excuse_slip_id]) }}" class="view-button">View</a>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No excuse slips found.</p>
            @endif

        </div>
    </div>
        @endsection

<style>
    .teacher-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Montserrat', sans-serif;

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

    .btn-approved {
        background-color: #28a745;
        height: 30px; /* Set the height you desire */
        width: 40%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-approved:hover {
        background-color: darkgreen;
        height: 30px; /* Set the height you desire */
        width: 45%; /* Full width of the container */
        
    }
    .btn-reject {
        background-color: red;
        height: 30px; /* Set the height you desire */
        width: 40%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-reject:hover {
        background-color: darkred;
        height: 30px; /* Set the height you desire */
        width: 45%; /* Full width of the container */
        
    }
</style>
