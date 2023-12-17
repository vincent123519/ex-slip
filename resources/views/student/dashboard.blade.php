@extends('components.stud')

@section('content')
    <div class="student-details-container">
        <h1>Absence Request</h1>        <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Request Excuse Slip</a>

        <hr>

        <div class="manage-slip-container">

            <h1>Excuse Slips Dashboard</h1>

            @if($excuseSlips->isEmpty())
                <p>No Excuse Slips found.</p>
            @else
                <table class="excuse-slip-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Teacher</th>
                            <th>Course</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($excuseSlips as $excuseSlip)
                            <tr>
                                <td>{{ $excuseSlip->student->first_name }} {{ $excuseSlip->student->last_name }}</td>
                                <td>{{ $excuseSlip->teacher->first_name }} {{ $excuseSlip->teacher->last_name }}</td>
                                <td>{{ $excuseSlip->course->course_name }}</td>
                                <td>{{ $excuseSlip->start_date }}</td>
                                <td>{{ $excuseSlip->end_date }}</td>
                                <td>{{ $excuseSlip->status->status_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        padding: 12px 400px;
        font-size: 20px;
        text-align: center;
        text-decoration: none;
        background-color: #28a745;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s;
        border: 5px solid #218838;
    }

    .create-slip-button:hover {
        background-color: #218838;
    }

    .manage-slip-container {
        margin-top: 20px;
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

    .alert {
        margin-top: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th, .excuse-slip-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
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
