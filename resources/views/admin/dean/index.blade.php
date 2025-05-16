@extends('components.admin')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Deans List</h2>
        <table id="dean" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>School</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deans as $dean)
                    <tr>
                        <td>{{ $dean->user->username }}</td>
                        <td>{{ $dean->first_name }}</td>
                        <td>{{ $dean->last_name }}</td>
                        <td>{{ $dean->school->school_name }}</td>
                        <td>{{ $dean->email }}</td>
                        <td>
                            <a href="{{ route('admin.dean.edit', $dean->dean_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    /* Center the table and add some space around it */
    .container {
        max-width: 90%;
        margin: 0 auto;
    }

    /* Style the table */
    #dean {
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
    }

    /* Table header styles */
    #dean th {
        background-color: #04AA6D;
        color: white;
        text-align: left;
        padding: 12px;
    }

    /* Table row styles */
    #dean td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    /* Hover effects on rows */
    #dean tr:hover {
        background-color: #f1f1f1;
    }

    /* Style for the edit button */
    .btn {
        padding: 8px 16px;
        background-color: #ff9800;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #e68900;
    }

    /* Adding some spacing around the table and title */
    .mb-4 {
        margin-bottom: 30px;
    }

    /* Light table row background color */
    #dean tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
