@extends('components.stud')
@section('content')
    <div class="student-details-container">
        <h1>Absence Request</h1>
        <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Request Excuse Slip</a>
        <div class="manage-slip-container">

    <table class="excuse-slip-table">
        <thead>
            <tr>
                <th>Duration</th>
                <th>Status</th>
                <th>Counselor's Feedback</th>
                <th>Dean's Feedback</th>
                <th>Teacher's Feedback</th>
            </tr>
        </thead>
    </table>
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

    .excuse-slip-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .excuse-slip-table th, .excuse-slip-table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }
</style>
