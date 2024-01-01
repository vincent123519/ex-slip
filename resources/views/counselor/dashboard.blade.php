@extends('components.counselor')

@section('content')
    <div class="counselor-details-container">
        <h1>Absence Request</h1>
        <a href="" class="create-slip-button">Number of Excuse slip</a>
    </div>

    <div class="excuse-container">
        <h2>List of Student Excuse Slips</h2>

        @if($excuseSlips->count() > 0)
            <table class="excuse-slip-table">
                <thead>
                    <tr>
                        <th>Excuse Slip No.</th>
                        <th>Student Name</th>
                        <th>Reason</th>
                        <th>Duration</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($excuseSlips as $index => $excuseSlip)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</td>
                            <td>{{ $excuseSlip->reason }}</td>
                            <td>{{ $excuseSlip->start_date }} to {{ $excuseSlip->end_date }}</td>
                            <!-- <td>{{ $excuseSlip->status->status_name }}</td> -->
                            <td>
                                <form action="{{ route('excuse.approve', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-approved">Note</button>
                                </form>

                                <!-- <form action="{{ route('excuse.reject', ['id' => $excuseSlip->excuse_slip_id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-reject">Reject</button>
                                </form> -->
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
@endsection


<style>
    body{
        font-family: 'Montserrat', sans-serif;
    }
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
        padding: px;
        text-align: center;
    }

    .excuse-slip-table th {
        background-color: #f2f2f2;
    }

    .excuse-slip-table td {
        vertical-align: top;
    }

    .excuse-slip-table tbody td {
    }
    
</style>