@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Teachers</h1>
        <table id="teachers" class="table">
            <thead>
                <tr>
                    <th>ID | Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>School</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->teacher_id }} | {{ $teacher->user->username }}</td>
                        <td>{{ $teacher->first_name }}</td>
                        <td>{{ $teacher->last_name }}</td>
                        <td>{{ $teacher->department->department_name }}</td>
                        <td>{{ $teacher->department->school->school_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    .container {
        position: relative;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 80%;
        margin: 20px auto;
        margin-right: 30px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .container h1 {
        margin-top: 20px;
        text-align: center;
    }

    #teachers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    #teachers td,
    #teachers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #teachers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #teachers tr:hover {
        background-color: #ddd;
    }

    #teachers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>