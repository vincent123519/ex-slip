@extends('components.admin')

@section('content')
    <div class="container">
        <h1>Counselors</h1>
        <table id="counselor" class="table">
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
                @foreach ($counselors as $counselor)
                    <tr>
                        <td>{{ $counselor->counselor_id }}-{{ $counselor->user->username }}</td>
                        <td>{{ $counselor->last_name }}</td>
                        <td>{{ $counselor->first_name }}</td>
                        <td>{{ $counselor->department->department_name }}</td>
                        <td>{{ $counselor->department->school->school_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

    <style>
        #counselor {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 60%;
            margin-left: 350px;
        }

        #counselor td, #counselor th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #counselor tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #counselor tr:hover {
            background-color: #ddd;
        }

        #counselor th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
