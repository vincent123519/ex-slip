@extends('components.admin')

@section('content')
    <div class="container">
        <h1>All Deans</h1>
        <table id="dean" class="table">
            <thead>
                <tr>
                    <th>Dean ID - User Account</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>School</th>
                    <th>Email</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                @foreach ($deans as $dean)
                    <tr>
                        <td>{{ $dean->dean_id }} | {{ $dean->user->username }}</td>
                        <td>{{ $dean->first_name }}</td>
                        <td>{{ $dean->last_name }}</td>
                        <td>{{ $dean->school->school_name }}</td>
                        <td>{{ $dean->email }}</td>
                        <td>
                            <a href="{{ route('admin.dean.edit', $dean->dean_id) }}" class="btn btn-primary">Edit</a>
                        </td> <!-- Edit button -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    #dean {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 60%;
        margin-left: 350px;
    }

    #dean td, #dean th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #dean tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #dean tr:hover {
        background-color: #ddd;
    }

    #dean th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    .btn {
        padding: 6px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>