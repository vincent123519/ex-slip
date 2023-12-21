@extends('components.counselor')
@section('content')
    <div class="counselor-details-container">
        <h1>Absence Request</h1>
        <a href="" class="create-slip-button"> Number of Excuse slip</a>
    </div>

    <div class="excuse-container">
        <h2>List of Student Excuse Slips</h2>
            @if($excuseSlips->count() > 0)
                @foreach($excuseSlips as $index => $excuseSlip)
                    <div class="excuse-slip">
                        <h3>Excuse Slip No. {{ $index + 1 }}</h3>
                        <table class="excuse-slip-table">
                            <thead>
                                <tr>
                                <th>Student Name</th>
                                <th>Reason</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>{{ $excuseSlip->student->first_name}} {{ $excuseSlip->student->last_name}}</td>
                                <td>{{ $excuseSlip->reason}}</td>
                                <td> {{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</td>
                                <td>{{ $excuseSlip->status->status_name }}</td>
                                <!-- <td><button class="btn-approved">Approve</button> <button class="btn-reject">Reject</button></td> -->
                                <td>
                                    <form action="{{ route('excuse.approve', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-approved">Approve</button>
                                    </form>
                                    
                                    <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-reject">Reject</button>
                                    </form>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <p>No excuse slips found.</p>
            @endif

        </div>
        @endsection

<style>
    .counselor-details-container {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .excuse-container {
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

    .excuse-slips-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .excuse-slip {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        width: 95%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .excuse-slip p {
        margin: 0 0 10px;
    }

    .excuse-slip strong {
        font-weight: bold;
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

    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th, .excuse-slip-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .excuse-slip-table th {
        background-color: #f2f2f2;
    }

    .excuse-slip-table td {
        vertical-align: top;
    }

    .excuse-slip-table tbody td {
        white-space: nowrap; /* Prevent line breaks in table cells */
    }
    
</style>