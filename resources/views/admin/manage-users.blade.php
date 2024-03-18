@extends('components.admin')

@section('content')
<div class="manage-users-container">
    <h1>Manage Users Password</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manage-users') }}" method="GET">
        <div class="form-group">
            <label for="role_filter">Filter by Role:</label>
            <select name="role_filter" id="role_filter" class="form-control" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Head Counselor">Head Counselor</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
                <option value="Counselor">Counselor</option>
                <option value="Dean">Dean</option>
                <option value="Admin">Admin</option>
                <!-- Add reset option -->
                <!-- Add other roles as needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-reset">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
            </svg>
            
        </button>
    </form>

    <table class="user-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Useraccount</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    @if($user->role)
                        {{ $user->role->role_name }}
                    @else
                        No role assigned for user {{ $user->name }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('edit-user', $user) }}" class="btn btn-edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </a>
                    <form action="{{ route('delete-user', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

    .manage-users-container {
        position: relative;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 80%;
        margin: 20px auto;
        margin-right: 30px;
    }

    /* CSS styles for the user table */
    .user-table {
        width: 95%;
        margin-top: 10px;
    }

    .user-table th,
    .user-table td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: left;
        font-size: 14px;
    }

    .user-table th {
        background-color: #4CAF50;
        color: white;
    }

    /* Change delete button color to yellow */
    .btn-danger {
        background-color: white; /* Change to white */
        color: #333;
        border: 1px solid #ccc;
    }

    /* Style for the reset button */
    .btn-reset {
        background-color: white; /* Change to white */
        color: #333;
        border: 1px solid #ccc;
    }

    /* Style for the edit button */
    .btn-edit {
        background-color: white; /* Change to white */
        color: #333;
        border: 1px solid #ccc;
    }
</style>

@endsection
