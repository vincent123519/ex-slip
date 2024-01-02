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
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Duration day</th>
                            <th>Counselor Feedback</th>
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
                                <td>{{ $excuseSlip->remarks }}</td>
                                <td width="500">
                                <form action="{{ route('excuse.approvedean', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-approved">Approve</button>
                                </form>
                                <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-reject">Reject</button>
                                </form>
                                    <form action="{{ route('excuse-slips.send-to-teacher', ['excuseSlipId' => $excuseSlip->excuse_slip_id, 'teacherId' => $excuseSlip->teacher_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn-send">Send to Teacher</button>
                                    </form>
                                    <a href="{{ route('excuse_slips.show', ['excuse_slip_id' => $excuseSlip->excuse_slip_id]) }}" class="view-button">View</a>
                                </td>

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
    font-family: 'Montserrat', sans-serif;

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
        width: 30%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-approved:hover {
        background-color: darkgreen;
        height: 30px; /* Set the height you desire */
        width: 35%; /* Full width of the container */
        
    }
    .btn-reject {
        background-color: red;
        height: 30px; /* Set the height you desire */
        width: 30%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-reject:hover {
        background-color: darkred;
        height: 30px; /* Set the height you desire */
        width: 35%; /* Full width of the container */
        
    }
    .btn-send {
        background-color: orange;
        height: 30px; /* Set the height you desire */
        width: 30%; /* Full width of the container */
        border: none;
        border-radius: 5px;
        color: white;
    }

    .btn-send:hover {
        background-color: darkblue;
        height: 30px; /* Set the height you desire */
        width: 35%; /* Full width of the container */
        
    }
</style>
