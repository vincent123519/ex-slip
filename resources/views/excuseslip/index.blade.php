@extends('components.layout') <!-- You might need to create this layout -->
@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Excuse Slips</title>
</head>
<div class="manage-slip-container">
    <h1>Excuse Slips</h1>

    <table class="excuse-slip-table">
        <thead>
            <tr>
                <th>Excuse Slip ID</th>
                <th>Student</th>
                <th>Teacher</th>
                <th>Counselor</th>
                <th>Course</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($excuseSlips as $excuseSlip)
            <tr>
                <td>{{ $excuseSlip->id }}</td>
                <td>{{ $excuseSlip->student->name }}</td>
                <td>{{ $excuseSlip->teacher->name }}</td>
                <td>{{ $excuseSlip->counselor->name }}</td>
                <td>{{ $excuseSlip->course->name }}</td>
                <td>{{ $excuseSlip->status->name }}</td>
                <td>
                    <a href="{{ route('excuse_slips.show', ['id' => $excuseSlip->id]) }}">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">No excuse slips found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('excuse_slips.create') }}" class="create-slip-button">Create Excuse Slip</a>

</div>
@endsection

</html>

<style>.manage-slip-container {
    /* background-color: rgb(243 254 240 / 98%); */
    padding: 5px;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto;
    margin-right: 30px;


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

.excuse-slip-table th {
    background-color: #f2f2f2;
}

.excuse-slip-table tr:hover {
    background-color: #e0e0e0;
}
.create-slip-button {
    display: block;
    margin: 20px 0;
    padding: 10px;
    background-color: green;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
}

.create-slip-button:hover {
    background-color: teal;
}
</style>